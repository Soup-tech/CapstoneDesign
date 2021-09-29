function redirect(name) {
    const params = {
        name: name
    };
    const options = {
        method: "POST",
        body: JSON.stringify(params)
    };
    fetch("http://localhost:3000/caregiver/caregiver-information.php",options);
    
    //window.location.replace("/caregiver/caregiver-information.php");
}