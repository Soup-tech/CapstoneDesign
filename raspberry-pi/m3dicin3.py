#!/usr/bin/python3
########################################
## Created by Maximillian A. Campbell ##
########################################

# ======= Modules =======
import mariadb
import sys
import os
import signal
import subprocess
import numpy as np
import RPi.GPIO as GPIO
from time import sleep
from gpiozero import Button, PWMLED
from signal import pause
from pydub import AudioSegment
from pydub.playback import play
from datetime import datetime

# ======= Variables =======
button = Button(2)
dispense = False

day_count = 1  
part_count = 1
# ======= Function =======
def mariadb_connection():
    """
    Establishes connection to MariaDB
    Returns connection object
    """
    try:
        conn = mariadb.connect(
                user = "root",
                password = "G0dH@d3s",
                host = "127.0.0.1",
                port = 3306,
                database = "capstone"
            )
    except mariadb.Error as e:
        print(f"Error connecting to MariaDB Platform: {e}")
        sys.exit(1)

    return conn.cursor()

def breath():
    """
    Causes LED to start "breathing"
    Breathing indicates it is time to take medicine
    """
    led = PWMLED(17)
    toggle = 1
    while (not button.is_pressed):
        if (toggle == 1):
            for i in np.arange(0,1,0.05):
                led.value = i
                if (button.is_pressed):
                    sys.exit(0)
                sleep(0.05)
            led.value = 1
            toggle = 0
        elif (toggle == 0):
            for d in np.arange(1,0,-0.05):
                led.value = d
                if (button.is_pressed):
                    sys.exit(0)
                sleep(0.05)
            led.value = 0
            toggle = 1

        sleep(0.5) # Change to breath faster/slower
    sys.exit(0)

def motor():
    """
    Stepper motor controller
    """
    control_pins = [12,16,20,21] # GPIO pins 
    seq = [[1,0,0,0],
           [1,1,0,0],
           [0,1,0,0],
           [0,1,1,0],
           [0,0,1,0],
           [0,0,1,1],
           [0,0,0,1],
           [1,0,0,1]]

    for pin in control_pins:
        GPIO.setup(pin,GPIO.OUT)
        GPIO.output(pin,0)

    for i in range(512):
        for halfstep in range(8):
            for pin in range(4):
                GPIO.output(control_pins[pin], seq[halfstep][pin])
            sleep(0.001) # default is 0.001
    
    # return
    sys.exit(0) # I left this in here to remember the 2 months of debugging I endured because of my dumbass.

def audio():
    """
    Audio player
    """
    looper = AudioSegment.from_mp3("sounds/screaming.mp3") # audio file here
    while (not button.is_pressed):
        looper = looper + 1
        play(looper)
    
    sys.exit(0)

def reFormat():
    """
    Puts the format of the counters in this script
    into the same format as in the database.
    """
    return str(day_count) + '-' + str(part_count)

# ======= Main =======

while True:
    cur = mariadb_connection()
    print("-------------------------------------------------")
    print("| [+] Made mariadb connection\t\t\t|")
    try:
        cur.execute("SELECT * FROM medicine")
    except mariadb.Error as e:
        print(f"Error pulling information from MariaDB: {e}")
    
    # Pull current time to the nearest minute
    n = datetime.now()
    current_time = n.strftime("%H:%M")
    print("| [+] Current Time: {}\t\t\t|".format(current_time))
    
    # Reformat day and part counter
    world = reFormat()
    print("| [+] World: {}\t\t\t\t|".format(world))

    # Pull information from database
    print("| [+] Checking db times\t\t\t\t|")
    for row in cur:
        # Error checking
        if (row[3] is None): # Is row None type?
            continue
        elif (len(row[3]) == 0): # Is there anything in time slot
            continue
        
        # Check for proper day and part
        if ((row[1] == world) and (row[3] == current_time)):
            print("| [+] Med Time\t\t\t\t\t|")
            print("|\t[+] {} @ {} on {}\t|".format(row[0],row[3],row[1]))
            dispense = True
    
    cur.close()
    sleep(10)
    
    # Time to take medication begin notification actions
    if (dispense):
        print("| [+] Time to Dispense!\t\t\t\t|")
        b = os.fork()
        if (b == 0):
            print("| [+] Breathing\t\t\t\t\t|")
            breath()

        a = os.fork()
        if (a == 0):
            print("| [+] Audio\t\t\t\t\t|")
            audio()

        # Wait for user interaction
        print("| [+] Waiting for button push\t\t\t|")
        while (not button.is_pressed):
            pass

        print("| [+] Button has been pushed\t\t\t|")
        
        # Killing audio
        ffplay = subprocess.Popen('ps aux | grep ffplay | cut -d " " -f 8',shell=True,stdout=subprocess.PIPE)
        pid = ffplay.stdout.read().decode('utf-8')
        pid = pid.split('\n')
        os.system('kill ' + pid[0])
        
        m = os.fork()
        if (m == 0):
            print("| [+] Motor\t\t\t|")
            motor()
       
        sleep(5)
        os.kill(b,signal.SIGKILL)
        os.kill(a,signal.SIGKILL)
        os.kill(m,signal.SIGKILL)

        # Waiting for child pocesses to clean up
        os.wait()
        os.wait()
        os.wait()

        # Update script information
        part_count += 1
        if (part_count == 3):
            part_count = 1
            day_count += 1
            
            if (day_count == 15):
                day_count = 1
        
        dispense = False
        print("| [+] Finished Dispensing!\t\t|")


