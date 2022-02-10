<!DOCTYPE html>
<html lang="en">
  <head>
    <h1>MedMag</h1>
	  <img src="assets/MED-MAG_NoBG.png" />
	  <p>Medicine Magazine (MedMag) is the product of the senior design project of Mathew Berlo, Maximillian Campbell, Gregory Farley and Dennis Zidarov. The goal of the MedMag was to enable independent living for the elderly and mentally disabled by giving them peace of mind in regards to their medication management. The MedMag project was designed and implemented from January 2021 to December 2021.</p>
    <h1>Table of Contents</h1>
	  <ul>
		  <li><a href="mission">Mission Statement</a></li>
		  <li><a href="arch">Overall Architecture</a></li>
		  <li><a href="technologies">Technologies</a></li>
		  <ul>
			  <li>External Design</li>
			  <li>Hardware</li>
			  <li>Software</li>
		  </ul>
		  <li>Conclusion</li>
	  </ul>
  </head>
  
  <body>
	  <h1><a id="mission">Mission Statement</a></h1>
	  <p><b>To design and build an automatic medication dispenser to allow elderly, mentally disabled and mentally ill to take medication at appropriate times, without the risk of missing medication intake times or double dosing.</b></p>
	  <p>In the United States many people take prescription medications, particularly the elderly population. In the 50-64 age group the average individual has 13 annually filled prescriptions, those aged 65-79 have on average 20 yearly prescriptions, and those 80+ have 22. This indicates that the device should have the capacity to store and dispense at minimum 20 distinct medications.</p>
	  <p>Extensive background research has been done from small $20 devices with minimum functionality to $1,500 devices that act as smart devices by interacting in the home. Medication Dispensing Devices need to be intuitive and easy to use for both the patient and the caregiver, allowing for scheduled dispensation of medication. In addition to being intuitive the device needs to have a storage capacity capable of storing approximately 2 weeks worth of medication for the average user.</p>
	  <h1><a id="arch">Overall Architecture</a></h1>
    <h2>Raspberry Pi</h2>
    <p>The raspberry pi is the brains of the MegMag. There are two software parts that make up the MedMag:</p>
    <ul>
      <li>The Web Application</li>
      <li>m3dicin3 Daemon</li>
    </ul>
    <p>Users will be able to login and interact with the MedMag. Interactions such as adding and removing medication, editing user information and looking at statistics. The m3dicin3 daemon reads times of dispensing from the database and performs actions to notify the user and dispense medication.</p>
    <p>TODO</p>
    <ul>
      <li>Enable cronjob</li>
      <li>Enable TLS for the web server</li>
      <li>Configure a domain name for the MedMag</li>
    </ul>
    <h2>Web Application</h2>
    <h3>Login/Setup</h2>
    <p>Initial setup of the Medmag has the default credentials:</p>
    <ul>
      <li>username: admin</li>
      <li>password: admin2021</li>
    </ul>
    <p>After loggin in you will be presented with a registration page. Fill in your information as well as change the default password. Afterwards you will be directed to the login page to login to your MedMag.</p>
    <p>TODO:</p>
    <ul>
	<li>Second sql check in update.php</li>
    </ul>
    <h3>Caregiver</h3>
    <p>The caregiver menu allows for adding, editing and removing caregivers. Caregivers act as admins of the MedMag as they can add new medication, removing current medication and look at statistics concerning the patient.</p>
    <p>TODO:</p>
    <ul>
      <li>Create edit caregiver form</li>
      <ul>
        <li>Select caregiver</li>
      </ul>
      <li>Create remove caregiver form</li>
    </ul>
    <h3>History Menu</h3>
    <p>The history menu shows statistics from the last ~30 days (maybe?). This includes the name of medication taken, dosage, the time the medication was supposed to be dispensed and the time the medication was actually dispensed.</p> 
    <p>TODO:</p>
    <ul>
      <li>Create history form</li>
      <li>Record when medication was actually dispensed</li>
    </ul>
    </ul>
    <h2>m3dicin3 Daemon</h2>
    <p>The m3dicin3 daemon is the second half of the MedMag. This daemon determines when to dispense medication.</p>
    <p>TODO:</p>
    <ul>
      <li>Create reset button</li>
    </ul>
  </body>
</html>
