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
dispense = 0

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

    print("\t[+] Setting up pins")
    for pin in control_pins:
        GPIO.setup(pin,GPIO.OUT)
        GPIO.output(pin,0)

    print("\t[+] Stepping")
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

# ======= Main =======

while True:
    cur = mariadb_connection()
    print("[+] Made mariadb connection")
    try:
        cur.execute("SELECT * FROM medicine")
    except mariadb.Error as e:
        print(f"Error pulling information from MariaDB: {e}")
    
    # Pull current time to the nearest minute
    n = datetime.now()
    current_time = n.strftime("%H:%M")
    print("[+] Current Time: {}\n".format(current_time))

    # Pull information from database
    for row in cur:
        med_time = ":".join(str(row[2]).split()[1].split('.')[0].split(':')[0:2])
        
        if (current_time == med_time):
            dispense = 1
            break
    
    cur.close()
    sleep(5)
    # Time to take medication begin notification actions
    if (dispense == 1):
        print("[+] Time to Dispense!")
        b = os.fork()
        if (b == 0):
            print("[+] Breathing")
            breath()

        a = os.fork()
        if (a == 0):
            print("[+] Audio")
            audio()

        # Wait for user interaction
        print("[+] Waiting for button push")
        while (not button.is_pressed):
            pass

        print("[+] Button has been pushed")
        
        # Killing audio
        ffplay = subprocess.Popen('ps aux | grep ffplay | cut -d " " -f 9',shell=True,stdout=subprocess.PIPE)
        pid = ffplay.stdout.read().decode('utf-8')
        pid = pid.split('\n')
        os.system('kill ' + pid[0])
        
        m = os.fork()
        if (m == 0):
            print("[+] Motor")
            motor()
       
        sleep(5)
        os.kill(b,signal.SIGKILL)
        os.kill(a,signal.SIGKILL)
        os.kill(m,signal.SIGKILL)

        # Waiting for child pocesses to clean up
        os.wait()
        os.wait()
        os.wait()

        dispense = 0
        print("[+] Finished Dispensing!")
        sleep(60)



