<!DOCTYPE html>
<html lang="en">
  <head>
    <h1>MedMag</h1>
    <p>TODO:</p>
    <ul>
      <li>Create better header for README</li>
    </ul>
  </head>
  
  <body>
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
      <li>Create add caregiver form</li>
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
    <h3>Medication Amount</h3>
    <p>Shows current medication amount and expected refill date.</p>
    <p>TODO:</p>
    <ul>
      <li>Create medication amount page</li>
      <ul>
        <li>Calculate expected refill date based on current medication amount</li>
      </ul>
    </ul>
    <h2>m3dicin3 Daemon</h2>
    <p>The m3dicin3 daemon is the second half of the MedMag. This daemon determines when to dispense medication.</p>
    <p>TODO:</p>
    <ul>
      <li>Pull and store times from the database</li>
      <li>Optimize sound notification</li>
    </ul>
  </body>
</html>
