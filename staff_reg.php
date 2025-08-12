<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Use defaults if not set
    $full_name = $_POST['full_name'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $nationality = $_POST['nationality'] ?? '';
    $address = $_POST['address'] ?? '';
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $country = $_POST['country'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $email = $_POST['email'] ?? '';
    $id_type = $_POST['id_type'] ?? '';
    $id_number = $_POST['id_number'] ?? '';
    $categories = $_POST['categories'] ?? 'N/A'; // default value
    $highest_level = $_POST['highest_level'] ?? '';
    $availability = $_POST['availability'] ?? '';
    $familiar_cricket = $_POST['familiar_cricket'] ?? '';
    $open_training = $_POST['open_training'] ?? '';
    $travel_international = $_POST['travel_international'] ?? '';
    $valid_passport = isset($_POST['valid_passport']) ? 1 : 0;
    $confirm = isset($_POST['confirm']) ? 1 : 0;
    $conduct = isset($_POST['conduct']) ? 1 : 0;

    $sql = "INSERT INTO staff_reg (
        full_name, dob, gender, nationality, address, city, state, country,
        mobile, email, id_type, id_number, categories, highest_level,
        availability, familiar_cricket, open_training, travel_international,
        valid_passport, confirm, conduct
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssssssssssssssssiii",
        $full_name,
        $dob,
        $gender,
        $nationality,
        $address,
        $city,
        $state,
        $country,
        $mobile,
        $email,
        $id_type,
        $id_number,
        $categories,
        $highest_level,
        $availability,
        $familiar_cricket,
        $open_training,
        $travel_international,
        $valid_passport,
        $confirm,
        $conduct
    );

if ($stmt->execute()) {
    echo "
    <div id='customAlert' class='alert-box success'>
        Staff Registration Successful!
    </div>
    <script>
        setTimeout(function(){
            window.location.href = 'staff_reg.php';
        }, 2000);
    </script>
    ";
} else {
    echo "
    <div id='customAlert' class='alert-box error'>
        Error: Unable to register staff.
    </div>
    <script>
        setTimeout(function(){
            window.location.href = 'staff_reg.php';
        }, 2000);
    </script>
    ";
}


    $stmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>XCL Staff Registration</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link href="assets/css/main.css" rel="stylesheet" media="screen">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background: #f8f9fa; }
.progressbar {
    display: flex; justify-content: space-between; counter-reset: step;
    margin-bottom: 30px; position: relative;
}
.progressbar::before {
    content: ''; position: absolute; top: 50%; left: 0; width: 100%; height: 4px;
    background-color: #dcdcdc; z-index: -1; transform: translateY(-50%);
}
.progress-step {
    width: 35px; height: 35px; background-color: #dcdcdc; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: bold; color: #fff;
}
.progress-step.active { background-color: #00cd8a; }
.form-step { display: none; }
.form-step.active { display: block; }
.content-area {
    margin-left: 250px; /* same as .sidebar width */
}
@media (max-width: 600px) {
    .content-area {
        margin-left: 60px;
    }
}

.alert-box {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 20px 30px;
    font-size: 16px;
    font-weight: bold;
    color: white;
    border-radius: 8px;
    text-align: center;
    z-index: 9999;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.3);
    animation: fadeInOut 2s ease-in-out forwards;
    min-width: 250px;
}

.alert-box.success { background-color: #28a745; } /* Green */
.alert-box.error { background-color: #dc3545; }  /* Red */

@keyframes fadeInOut {
    0% { opacity: 0; transform: translate(-50%, -60%); }
    10% { opacity: 1; transform: translate(-50%, -50%); }
    90% { opacity: 1; }
    100% { opacity: 0; transform: translate(-50%, -40%); }
}


</style>
</head>
<body>
<?php require ('header.php'); ?>
<div class="content-area">
<div class="container my-4">
<h2 class="text-center mb-4">XCL Staff Registration</h2>

<!-- Progress Tracker -->
<div class="progressbar mb-4">
    <div class="progress-step active">1</div>
    <div class="progress-step">2</div>
    <div class="progress-step">3</div>
    <div class="progress-step">4</div>
    <div class="progress-step">5</div>
    <div class="progress-step">6</div>
    <div class="progress-step">7</div>
    <div class="progress-step">8</div>
</div>

<form method="POST" enctype="multipart/form-data" id="regForm">

<!-- STEP 1 -->
<div class="form-step active">
    <h5>Section 1 – Personal Details</h5>
    <div class="row g-3">
        <div class="col-md-6"><label>Full Name *</label><input type="text" name="full_name" class="form-control" required></div>
        <div class="col-md-3"><label>DOB *</label><input type="date" name="dob" class="form-control" required></div>
        <div class="col-md-3"><label>Gender *</label>
            <select name="gender" class="form-control" required>
                <option value="">Select</option><option>Male</option><option>Female</option><option>Other</option>
            </select>
        </div>
        <div class="col-md-4"><label>Nationality *</label><input type="text" name="nationality" class="form-control" required></div>
        <div class="col-md-8"><label>Address *</label><input type="text" name="address" class="form-control" required></div>
        <div class="col-md-3"><label>City *</label><input type="text" name="city" class="form-control" required></div>
        <div class="col-md-3"><label>State/Province *</label><input type="text" name="state" class="form-control" required></div>
        <div class="col-md-3"><label>Country *</label><input type="text" name="country" class="form-control" required></div>
        <div class="col-md-3"><label>Mobile *</label><input type="text" name="mobile" class="form-control" required></div>
        <div class="col-md-3"><label>WhatsApp</label><input type="text" name="whatsapp" class="form-control"></div>
        <div class="col-md-3"><label>Email *</label><input type="email" name="email" class="form-control" required></div>
        <div class="col-md-3"><label>Alt Email</label><input type="email" name="alt_email" class="form-control"></div>
    </div>
    <div class="mt-3 text-end"><button type="button" class="btn btn-primary next-btn">Next</button></div>
</div>

<!-- STEP 2 -->
<div class="form-step">
    <h5>Section 2 – Identification & Documents</h5>
    <div class="row g-3">
        <div class="col-md-4">
            <label>ID Type *</label>
            <select name="id_type" class="form-control" required>
                <option value="">Select</option><option>Passport</option><option>National ID</option><option>Driving License</option>
            </select>
        </div>
        <div class="col-md-4"><label>ID Number *</label><input type="text" name="id_number" class="form-control" required></div>
        <div class="col-md-4"><label>Upload ID *</label><input type="file" name="id_file" accept=".pdf,.jpg,.png" class="form-control" required></div>
        <div class="col-md-4"><label>Photo *</label><input type="file" name="photo" accept=".jpg,.png" class="form-control" required></div>
        <div class="col-md-4"><label>Resume/Profile *</label><input type="file" name="resume" accept=".pdf,.doc,.docx" class="form-control" required></div>
        <div class="col-md-4"><label>Certifications</label><input type="file" name="certifications[]" multiple class="form-control"></div>
    </div>
    <div class="mt-3 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
        <button type="button" class="btn btn-primary next-btn">Next</button>
    </div>
</div>

<!-- STEP 3 -->
<div class="form-step">
    <h5>Section 3 – Staff Profile</h5>
    <div class="row g-3">
        <div class="col-md-4">
            <label>Staff Role(s) *</label>
            <select name="primary_role" class="form-control" required>
                <option value="">Select</option>
                <option>Admin</option>
                <option>Manager</option>
                <option>Support Staff</option>
                <option>Logistics</option>
                <option>Technical Staff</option>
                <option>Field Supervisor</option>
                <option>Media Team</option>
                <option>Security</option>
                <!-- Add more roles as needed -->
            </select>
        </div>
        <div class="col-md-4"><label>Secondary Role</label><input type="text" name="secondary_role" class="form-control"></div>
        <div class="col-md-4"><label>Years of Experience *</label><input type="number" name="experience_years" class="form-control" required></div>
        <div class="col-md-4"><label>Highest Level Worked At *</label>
            <select name="highest_level" class="form-control" required>
                <option value="">Select</option><option>Local</option><option>State</option><option>National</option><option>International</option>
            </select>
        </div>
        <div class="col-md-4"><label>Languages Known *</label>
            <input type="text" name="languages" class="form-control" required>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
        <button type="button" class="btn btn-primary next-btn">Next</button>
    </div>
</div>

<!-- STEP 4 -->
<div class="form-step">
    <h5>Section 4 – Skills and Training</h5>
    <div class="row g-3">
        <div class="col-md-6"><label>Relevant Skills *</label>
            <textarea name="skills" class="form-control" rows="3" required></textarea>
        </div>
        <div class="col-md-3"><label>Familiar With Event Operations? *</label>
            <select name="event_ops" class="form-control" required><option value="">Select</option><option>Yes</option><option>No</option></select>
        </div>
        <div class="col-md-3"><label>Open to Training? *</label>
            <select name="training" class="form-control" required><option value="">Select</option><option>Yes</option><option>No</option></select>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
        <button type="button" class="btn btn-primary next-btn">Next</button>
    </div>
</div>

<!-- STEP 5 -->
<div class="form-step">
    <h5>Section 5 – Travel & Health</h5>
    <div class="row g-3">
        <div class="col-md-3"><label>Willing to travel internationally? *</label>
            <select name="travel" class="form-control" required><option value="">Select</option><option>Yes</option><option>No</option></select>
        </div>
        <div class="col-md-3"><label>Valid Passport? *</label>
            <select name="passport" class="form-control" required><option value="">Select</option><option>Yes</option><option>No</option></select>
        </div>
        <div class="col-md-3"><label>Passport Expiry Date</label><input type="date" name="passport_expiry" class="form-control"></div>
        <div class="col-md-3"><label>Medical Conditions</label><input type="text" name="medical" class="form-control"></div>
    </div>
    <div class="mt-3 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
        <button type="button" class="btn btn-primary next-btn">Next</button>
    </div>
</div>

<!-- STEP 6 -->
<div class="form-step">
    <h5>Section 6 – Availability & Commitment</h5>
    <div class="row g-3">
        <div class="col-md-4"><label>Availability *</label>
            <select name="availability" class="form-control" required>
                <option value="">Select</option><option>Full Season</option><option>Partial Season</option><option>Specific Dates</option>
            </select>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
        <button type="button" class="btn btn-primary next-btn">Next</button>
    </div>
</div>

<!-- STEP 7 -->
<div class="form-step">
    <h5>Section 7 – Emergency Contact</h5>
    <div class="row g-3">
        <div class="col-md-4"><label>Contact Person *</label><input type="text" name="em_contact" class="form-control" required></div>
        <div class="col-md-4"><label>Relationship *</label><input type="text" name="em_relation" class="form-control" required></div>
        <div class="col-md-4"><label>Contact Number *</label><input type="text" name="em_number" class="form-control" required></div>
        <div class="col-md-6"><label>Email</label><input type="email" name="em_email" class="form-control"></div>
    </div>
    <div class="mt-3 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
        <button type="button" class="btn btn-primary next-btn">Next</button>
    </div>
</div>

<!-- STEP 8 -->
<div class="form-step">
    <h5>Section 8 – Declaration</h5>
    <div class="form-check"><input class="form-check-input" type="checkbox" name="confirm" required> <label class="form-check-label">I confirm all the information provided is true and correct.</label></div>
    <div class="form-check"><input class="form-check-input" type="checkbox" name="conduct" required> <label class="form-check-label">I agree to abide by XCL’s staff code of conduct and confidentiality agreements.</label></div>
    <div class="mt-3 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
        <button type="submit" class="btn btn-success">Submit Registration</button>
    </div>
</div>

</form>
</div>
</div>

<script>
const steps = document.querySelectorAll(".form-step");
const nextBtns = document.querySelectorAll(".next-btn");
const prevBtns = document.querySelectorAll(".prev-btn");
const progressSteps = document.querySelectorAll(".progress-step");
let currentStep = 0;

nextBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        if (!validateForm()) return;
        currentStep++;
        updateFormSteps();
        updateProgressbar();
    });
});

prevBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        currentStep--;
        updateFormSteps();
        updateProgressbar();
    });
});

function updateFormSteps() {
    steps.forEach((step, index) => {
        step.classList.toggle("active", index === currentStep);
    });
}

function updateProgressbar() {
    progressSteps.forEach((step, idx) => {
        step.classList.toggle("active", idx <= currentStep);
    });
}

function validateForm() {
    const inputs = steps[currentStep].querySelectorAll("input, select, textarea");
    for (let input of inputs) {
        if (!input.checkValidity()) {
            input.reportValidity();
            return false;
        }
    }
    return true;
}
</script>
</body>
</html>