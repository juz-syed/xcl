<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php"); 
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // File upload function
    function uploadFile($field) {
        global $uploadDir;

        // Handle multiple files
        if (isset($_FILES[$field]['name']) && is_array($_FILES[$field]['name'])) {
            $uploadedFiles = [];
            foreach ($_FILES[$field]['name'] as $key => $name) {
                if (!empty($name)) {
                    $filename = time() . '_' . basename($name);
                    move_uploaded_file($_FILES[$field]['tmp_name'][$key], $uploadDir . $filename);
                    $uploadedFiles[] = $filename;
                }
            }
            return implode(',', $uploadedFiles); // Store as comma-separated
        }
        // Handle single file
        elseif (!empty($_FILES[$field]['name'])) {
            $filename = time() . '_' . basename($_FILES[$field]['name']);
            move_uploaded_file($_FILES[$field]['tmp_name'], $uploadDir . $filename);
            return $filename;
        }
        return null;
    }

    // Gather POST data
    $full_name     = $_POST['full_name'] ?? '';
    $dob           = $_POST['dob'] ?? '';
    $gender        = $_POST['gender'] ?? '';
    $nationality   = $_POST['nationality'] ?? '';
    $address       = $_POST['address'] ?? '';
    $city          = $_POST['city'] ?? '';
    $state         = $_POST['state'] ?? '';
    $country       = $_POST['country'] ?? '';
    $mobile        = $_POST['mobile'] ?? '';
    $whatsapp      = $_POST['whatsapp'] ?? '';
    $email         = $_POST['email'] ?? '';
    $id_type       = $_POST['id_type'] ?? '';
    $id_number     = $_POST['id_number'] ?? '';
    $certifications = uploadFile('certifications'); // file upload

    // SQL query without "role"
    $sql = "INSERT INTO official_reg (
                full_name, dob, gender, nationality, address, city, state, country, 
                mobile, whatsapp, email, id_type, id_number, certifications
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "ssssssssssssss",
        $full_name, $dob, $gender, $nationality, $address, $city, $state, $country,
        $mobile, $whatsapp, $email, $id_type, $id_number, $certifications
    );

if ($stmt->execute()) {
    echo "
    <div id='customAlert' class='alert-box success'>
        Staff Registration Successful!
    </div>
    <script>
        setTimeout(function(){
            window.location.href = 'login_form.php';
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
            window.location.href = 'login_form.php';
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
<title>XCL Official Registration</title>
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

/* Push content down below fixed topbar */
.content-area {
    margin-left: 250px; /* space for sidebar */
    padding-top: 80px;  /* adjust this to match your topbar height */
}
@media (max-width: 600px) {
    .content-area {
        margin-left: 60px;
        padding-top: 80px; /* keep same top spacing for mobile */
    }
}


.progress-step.active { background-color: #00cd8a; }
.form-step { display: none; }
.form-step.active { display: block; }

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
<?php require ('topbar.php');?>
<?php require ('sidebar.php');?>
<div class="content-area">
<div class="container my-4">
<h2 class="text-center mb-4">XCL Other Staff Registration Form</h2>

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

<!-- Step 1 -->
<div class="form-step active">
    <h5>Section 1 – Personal Information</h5>
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
        <div class="col-md-3"><label>State *</label><input type="text" name="state" class="form-control" required></div>
        <div class="col-md-3"><label>Country *</label><input type="text" name="country" class="form-control" required></div>
        <div class="col-md-3"><label>Mobile *</label><input type="text" name="mobile" class="form-control" required></div>
        <div class="col-md-3"><label>WhatsApp</label><input type="text" name="whatsapp" class="form-control"></div>
        <div class="col-md-3"><label>Email *</label><input type="email" name="email" class="form-control" required></div>
    </div>
    <div class="mt-3 text-end"><button type="button" class="btn btn-primary next-btn">Next</button></div>
</div>

<!-- Step 2 -->
<div class="form-step">
    <h5>Section 2 – Identification & Documents</h5>
    <div class="row g-3">
        <div class="col-md-4"><label>ID Type *</label>
            <select name="id_type" class="form-control" required>
                <option value="">Select</option><option>Passport</option><option>National ID</option><option>Driving License</option>
            </select>
        </div>
        <div class="col-md-4"><label>ID Number *</label><input type="text" name="id_number" class="form-control" required></div>
        <div class="col-md-4"><label>Upload ID *</label><input type="file" name="id_file" accept=".pdf,.jpg,.png" class="form-control" required></div>
        <div class="col-md-4"><label>Photo *</label><input type="file" name="photo" accept=".jpg,.png" class="form-control" required></div>
        <div class="col-md-4"><label>Resume/CV *</label><input type="file" name="resume" accept=".pdf,.doc,.docx" class="form-control" required></div>
        <div class="col-md-4"><label>Certificates/Licenses</label><input type="file" name="certifications[]" multiple class="form-control"></div>
    </div>
    <div class="mt-3 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
        <button type="button" class="btn btn-primary next-btn">Next</button>
    </div>
</div>

<!-- Step 3 -->
<div class="form-step">
    <h5>Section 3 – Role Application</h5>
    <div class="mb-3"><label>Roles (Select multiple):</label>
        <select name="roles[]" multiple class="form-control" required>
            <option>Head Coach</option><option>Assistant Coach</option><option>Team Analyst</option>
            <option>Physiotherapist</option><option>Fitness Trainer</option><option>Team Doctor</option>
            <option>Photographer</option><option>Videographer</option><option>Social Media Manager</option>
            <option>Content Creator</option><option>PR & Media</option><option>Live Streaming Operator</option>
            <option>Venue Manager</option><option>Logistics Coordinator</option><option>Security</option>
            <option>Ground Staff</option><option>Equipment Manager</option><option>Hospitality</option><option>Other</option>
        </select>
    </div>
    <div class="row g-3">
        <div class="col-md-4"><label>Experience (Years) *</label><input type="number" name="experience_years" class="form-control" required></div>
        <div class="col-md-4"><label>Highest Level *</label>
            <select name="highest_level" class="form-control" required>
                <option value="">Select</option><option>Local</option><option>State</option><option>National</option><option>International</option>
            </select>
        </div>
        <div class="col-md-4"><label>Availability *</label>
            <select name="availability" class="form-control" required>
                <option value="">Select</option><option>Full season</option><option>Partial season</option><option>Specific dates</option>
            </select>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
        <button type="button" class="btn btn-primary next-btn">Next</button>
    </div>
</div>

<!-- Step 4 -->
<div class="form-step">
    <h5>Section 4 – Skills & Training</h5>
    <div class="mb-3"><label>Skills & Expertise *</label><textarea name="skills" class="form-control" required></textarea></div>
    <div class="mb-3"><label>Languages Spoken *</label><input type="text" name="languages" class="form-control" required></div>
    <div class="col-md-6"><label>Familiar with cricket operations? *</label>
        <select name="familiar_cricket" class="form-control" required><option value="">Select</option><option>Yes</option><option>No</option></select>
    </div>
    <div class="col-md-6"><label>Open to training? *</label>
        <select name="open_training" class="form-control" required><option value="">Select</option><option>Yes</option><option>No</option></select>
    </div>
    <div class="mt-3 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
        <button type="button" class="btn btn-primary next-btn">Next</button>
    </div>
</div>

<!-- Step 5 -->
<div class="form-step">
    <h5>Section 5 – Travel & Health Readiness</h5>
    <div class="row g-3">
        <div class="col-md-4"><label>Travel Internationally? *</label><select name="travel_international" class="form-control" required><option value="">Select</option><option>Yes</option><option>No</option></select></div>
        <div class="col-md-4"><label>Valid Passport? *</label><select name="valid_passport" class="form-control" required><option value="">Select</option><option>Yes</option><option>No</option></select></div>
        <div class="col-md-4"><label>Passport Expiry</label><input type="date" name="passport_expiry" class="form-control"></div>
        <div class="col-md-4"><label>Medical Condition? *</label><select name="medical_condition" class="form-control" required><option value="">Select</option><option>Yes</option><option>No</option></select></div>
        <div class="col-md-8"><label>If Yes, details:</label><input type="text" name="medical_details" class="form-control"></div>
    </div>
    <div class="mt-3 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
        <button type="button" class="btn btn-primary next-btn">Next</button>
    </div>
</div>

<!-- Step 6 -->
<div class="form-step">
    <h5>Section 6 – Emergency Contact</h5>
    <div class="row g-3">
        <div class="col-md-4"><label>Contact Name *</label><input type="text" name="emergency_name" class="form-control" required></div>
        <div class="col-md-4"><label>Relationship *</label><input type="text" name="emergency_relation" class="form-control" required></div>
        <div class="col-md-4"><label>Contact Number *</label><input type="text" name="emergency_contact" class="form-control" required></div>
        <div class="col-md-6"><label>Email</label><input type="email" name="emergency_email" class="form-control"></div>
    </div>
    <div class="mt-3 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
        <button type="button" class="btn btn-primary next-btn">Next</button>
    </div>
</div>

<!-- Step 7 -->
<div class="form-step">
    <h5>Section 7 – Declaration</h5>
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