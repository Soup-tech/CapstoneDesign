#!/usr/bin/python3

import sys
import os
import signal
import subprocess
import numpy as np
import RPi.GPIO as GPIO
from time import sleep
from signal import pause
from gpiozero import Button, PWMLED
from signal import pause
from pydub import AudioSegment
from pydub.playback import play

class Medmag:
    def __init__(self):
        self.button = Button(2)    
        self.led = PWMLED(17)

    def breath(self):
        """
        Causes the LED to start "breathing"
        Breathing is a visual indication that it is time to take
        your medication
        """
        toggle = 1
        while (not self.button.is_pressed):
            if (toggle == 1):
                for i in np.arange(0,1,0.05):
                    self.led.value = i
                    if (self.button.is_pressed):
                        sys.exit(0) 
                    sleep(0.05)
                self.led.value = 1
                toggle = 0
            elif (toggle == 0):
                for d in np.arange(1,0,-0.05):
                    self.led.value = d
                    if (self.button.is_pressed):
                        sys.exit(0) 
                    sleep(0.05)
                self.led.value = 0
                toggle = 1

            sleep(0.5) # Change to breath faster/slower
        sys.exit(0)

    def motor(self):
        """
        Stepper motor controller
        """
        control_pins = [12,16,20,21]
        seq = [[1,0,0,0],
               [1,1,0,0],
               [0,1,0,0],
               [0,1,1,0],
               [0,0,1,0],
               [0,0,1,1],
               [0,0,0,1],
               [1,0,0,1]]
        
        # Set pins
        for pin in control_pins:
            GPIO.setup(pin,GPIO.OUT)
            GPIO.output(pin,0)

        for i in range(512):
            for halfstep in range(8):
                for pin in range(4):
                    GPIO.output(control_pins[pin],seq[halfstep][pin])
                sleep(0.001) # Default is 0.001
    
        # Reset pins
        for pin in control_pins:
            GPIO.setup(pin,GPIO.OUT)
            GPIO.output(pin,0)

        sys.exit(0)

    def audio(self):
        """
        Audio player
        """
        looper = AudioSegment.from_mp3("sounds/screaming.mp3") # audio file here
        a = os.fork()
        if (a == 0):
            while (not self.button.is_pressed):
                play(looper)
                looper += 1
         
        while (not self.button.is_pressed):
            pass
        
        # Stop play(looper) from starting again
        os.kill(a,signal.SIGKILL)
        
        # Clean up audio process in system
        ffplay = subprocess.Popen('ps aux | grep ffplay | cut -d " " -f 9',shell=True,stdout=subprocess.PIPE)
        pid = ffplay.stdout.read().decode('utf-8')
        pid = pid.split('\n')
        os.system('kill ' + pid[0])
        
        sys.exit(0) 

    def button_control(self):
        return self.button.is_pressed
