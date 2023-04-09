function validateform() {

    //localStorage.clear();

    var fname = document.myform.fname.value;
    var lname = document.myform.lname.value;
    var emailID = document.myform.email.value;
    var phone = document.myform.phone.value;
    var address = document.myform.address.value;
    var day = document.getElementById("d").value;
    var month = document.getElementById("m").value;
    var year = document.getElementById("y").value;
    var gender = document.querySelector('input[name="gender"]:checked').value;
    var message = document.getElementById("message").value;
    var checkbox1 = document.getElementById("1");
    var checkbox2 = document.getElementById("2");
    var checkbox3 = document.getElementById("3");
    var checkbox4 = document.getElementById("4");


    if (fname == null || fname == "") {
        alert("First Name can't be blank");
        return false;
    }
    else if (validateFirstname(fname) == false) {
        return false;
    }
    if (lname == null || lname == "") {
        alert("Last Name can't be blank");
        return false;
    }
    else if (validateLastname(lname) == false) {
        return false;
    }
    if (emailID == null || emailID == "") {
        alert("Email can't be blank");
        return false;
    }
    else if (validateEmail(emailID) == false) {
        return false;
    }
    if (phone == null || phone == "") {
        alert("Phone number can't be blank");
        return false;
    }
    else if (validatePhone(phone) == false) {
        return false;
    }
    if (address == null || address == "") {
        alert("Address can't be blank");
        return false;
    }
    if (myform.Agree.checked == false) {
        alert('You must agree to the terms and conditions first!');
        return false;
    }
    localStorage.setItem('fname', fname);
    localStorage.setItem('lname', lname);
    localStorage.setItem('email', emailID);
    localStorage.setItem('phone', phone);
    localStorage.setItem('address', address);
    localStorage.setItem('day', day);
    localStorage.setItem('month', month);
    localStorage.setItem('year', year);
    localStorage.setItem('gender', gender);
    localStorage.setItem('message', message);

    // Initialize an empty array to store selected checkboxes
    let selectedCheckboxes = [];
    // Check which checkboxes are currently checked
    if (checkbox1.checked) {
        selectedCheckboxes.push(checkbox1.value);
    }
    if (checkbox2.checked) {
        selectedCheckboxes.push(checkbox2.value);
    }
    if (checkbox3.checked) {
        selectedCheckboxes.push(checkbox3.value);
    }
    if (checkbox4.checked) {
        selectedCheckboxes.push(checkbox4.value);
    }
    // Convert the array to a JSON string
    const selectedCheckboxesJSON = JSON.stringify(selectedCheckboxes);
    // Store the JSON string in local storage
    localStorage.setItem("selectedCheckboxes", selectedCheckboxesJSON);




    const confirmBox = document.querySelector(".confirm-box");
    document.getElementById("a").innerHTML = "First Name: " + fname;
    document.getElementById("b").innerHTML = "Last Name: " + lname;
    document.getElementById("c").innerHTML = "Email: " + emailID;
    document.getElementById("d").innerHTML = "Phone Number: " + phone;
    document.getElementById("e").innerHTML = "Address: " + address;
    document.getElementById("f").innerHTML = "Birth Date: " + day + "/" + month + "/" + year;
    document.getElementById("g").innerHTML = "Gender: " + gender;
    document.getElementById("h").innerHTML = "Where you heard about us: " + selectedCheckboxes;
    document.getElementById("i").innerHTML = "Message: " + message;
    confirmBox.style.display = "block";


}



function hideConfirmBox() {
    // Hide the custom confirm box
    const confirmBox = document.querySelector(".confirm-box");
    confirmBox.style.display = "none";
}

function performAction() {

    var fname = document.myform.fname.value;
    var lname = document.myform.lname.value;
    // Perform the action
    // Create an object to store the form values
    let formValues = { fname: fname, lname: lname };
    // Get the existing past form values from local storage, or create an empty array
    let pastFormValues = JSON.parse(localStorage.getItem("pastFormValues")) || [];
    // Add the new form values object to the array
    pastFormValues.push(formValues);
    // Save the updated array of past form values to local storage
    localStorage.setItem("pastFormValues", JSON.stringify(pastFormValues));

    alert("Your form has been successfully submitted!");

    // Hide the custom confirm box
    hideConfirmBox();
}

function validateFirstname(fname) {

    if (!/^[A-Z a-z]+$/.test(fname)) {
        alert("Please enter string characters only for first name!");
        return false;
    }
    return (true);
}

function validateLastname(lname) {

    if (!/^[A-Z a-z]+$/.test(lname)) {
        alert("Please enter string characters only for last name!");
        return false;
    }
    return (true);
}

function validateEmail(emailID) {
    atpos = emailID.indexOf("@");
    dotpos = emailID.lastIndexOf(".");

    if (atpos < 1 || (dotpos - atpos < 2)) {
        alert("Please enter email ID in correct format: example@domain.com");
        document.myform.email.focus();
        return false;
    }
    return (true);
}

function validatePhone(phone) {

    var regex = /^5\d{7}$/;
    if (!/^[0-9]+$/.test(phone)) {
        alert("Please enter numeric characters only for phone number!");
        return false;
    }
    else if (regex.test(phone) === false) {
        alert("Please enter a valid 8 digit mobile number in the correct format: 5*******");
        document.myform.phone.focus();
        return false;
    }
    return (true);
}

