#!/usr/bin/python3
# This script keeps track of when the magazine is
# set or unset.
# When unset, the med-mag will light up the red LED. This
# indicates that the med-mag needs to be refilled.
# When set, the medmag will light up the green LED indicating
# that it is running.

# ==== Modules ====
import subprocess
import os
import signal
from gpiozero import LED
from gpiozero import Button
from time import sleep

# ==== Variables ====
set_led = LED(14)
unset_led = LED(15)
button = Button(0)

# ==== Main ====
# Start state in unset (0)
state = 0
unset_led.on()
while True:

    # Having two processes indicates m3dicin3
    # Set/Unset button is pressed
    if (button.is_pressed):
        sleep(0.2)
        
        # State is currently unset
        if (state == 0):
            # This will change depending on where you finally place the raspberry-pi directory
            p = subprocess.Popen('~/Documents/CapstoneDesign/raspberry-pi/m3dicin3.py',shell=True,stdout=subprocess.PIPE) 
            # os.system('~/Documents/CapstoneDesign/raspberry-pi/m3dicin3.py')
            state = 1
            unset_led.off()
            set_led.on()
            
        # State is currently set
        elif (state == 1):
            # Kill the m3dicin3 process
            os.kill(p.pid + 1, signal.SIGKILL)
            
            # Set state, turn on unset LED and turn off set LED
            state = 0
            unset_led.on()
            set_led.off()
