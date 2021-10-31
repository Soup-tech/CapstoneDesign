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
from datetime import timedelta

# ======= Variables =======
button = Button(2)
dispense = False

expected_refill_date = ""
world = ""
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
        conn.autocommit = True
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

def writeHistory(pushTime,expectedTime,medicationName,amount):
    """
    Writes history values to the database
    """
    cur = mariadb_connection()
    # sql = "INSERT INTO `history`(`pushTime`, `expectedTime`, `dayCount`, `medicationName`, `amount`) VALUES (ee)
    try:
        cur.execute("INSERT INTO `history`(`pushTime`, `expectedTime`, `medicationName`, `amount`) VALUES (?,?,?,?)",(pushTime,expectedTime,medicationName,amount))
    except mariadb.Error as e:
        print(f"Error writing history to MariaDB: {e}")
    
    cur.close() 
    return

def killAudio():
    """
    Killing audio is tricky. I have to kill the audio in a specific way
    depending on the number of processes running.
    """
    # Get ffplay process. The location changes depending on the number of processes I think
    ffplay = subprocess.Popen('ps aux | grep ffplay | cut -d " " -f 8',shell=True,stdout=subprocess.PIPE)

    # Bytes to string
    pid = ffplay.stdout.read().decode('utf-8')

    # String to array of process ID's
    pid = pid.split('\n')
    
    # Kill processes
    for p in pid:
        os.system('kill {} 2> /dev/null'.format(p))

    return

def quickInfo(prevMedication, prevPushTime, nextMedication, nextWorld, expPushTime):
    """
    Updates the quick_info.csv file. This file is read by the web applciation to display
    quick alert information, history, medication amount, etc.
    """
    # Update expected refill date if we are at world 1-1
    if (world == "1-1"):
        strdt = str(datetime.today()).split(' ')[0]
        d = datetime.strptime(strdt, "%Y-%m-%d")
        expected_refill_date = d + timdelta(days=14)
    
    

    quick_info = open('quick_info.csv','w')
    
    # Write header for CSV file
    header = "Expected Refill Date,Previous Medication,Previous PushTime,Next Medication,Next World,Expected PushTime\n"
    quick_info.write(header)
    
    # Write updated information to CSV file
    info = "{},{},{},{},{},{}\n".format(expected_refill_date,prevMedication,prevPushTime,nextMedication,nextWorld,expPushTime)
    quick_info.write(info)

    quick_info.close()

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
            
            # History values
            medicationName = row[0]
            dayCount = row[1]
            amount = row[2]
            expectedTime = row[3]
    
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
        killAudio()
        
        # Start motor
        m = os.fork()
        if (m == 0):
            print("| [+] Motor\t\t\t|")
            motor()
       
        sleep(5)

        # Kill Processes and clean up
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

        # Write history to database
        pushTime = datetime.now()
        writeHistory(pushTime, expectedTime, medicationName, amount)

        # Update quick information file for web app
        # quickInfo(medicationName,pushTime,

        dispense = False
        print("| [+] Finished Dispensing!\t\t|")


