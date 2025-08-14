<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php"); 
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sql = "INSERT INTO player_reg (
        full_name, dob, gender, nationality, address, city, state, country,
        mobile, whatsapp, email, alt_email, id_type, id_number, photo_id,
        passport_photo, resume_profile, cricket_certifications, batting_style,
        bowling_style, primary_role, secondary_role, experience_years, highest_level,
        club_team, jersey_size, citizen_franchise, played_t20, t20_details,
        familiar_rules, open_training, weight_kg, height_cm, medical_conditions,
        medication, fit_for_cricket, availability, travel_international,
        valid_passport, passport_expiry, emergency_name, emergency_relation,
        emergency_contact, emergency_email, confirm, conduct
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssssssssssssssssssssssssssssssssssssssssssssss",
    $_POST['full_name'], $_POST['dob'], $_POST['gender'], $_POST['nationality'], $_POST['address'], $_POST['city'], $_POST['state'], $_POST['country'], $_POST['mobile'], $_POST['whatsapp'], $_POST['email'], $_POST['alt_email'],
    $_POST['id_type'], $_POST['id_number'], $_POST['photo_id'], $_POST['passport_photo'], $_POST['resume_profile'], $_POST['cricket_certifications'], $_POST['batting_style'], $_POST['bowling_style'], $_POST['primary_role'], $_POST['secondary_role'], $_POST['experience_years'], $_POST['highest_level'], $_POST['club_team'], $_POST['jersey_size'], $_POST['citizen_franchise'],
    $_POST['played_t20'], $_POST['t20_details'], $_POST['familiar_rules'], $_POST['open_training'], $_POST['weight_kg'], $_POST['height_cm'], $_POST['medical_conditions'], $_POST['medication'], $_POST['fit_for_cricket'], $_POST['availability'], $_POST['travel_international'], $_POST['valid_passport'], $_POST['passport_expiry'],
    $_POST['emergency_name'], $_POST['emergency_relation'], $_POST['emergency_contact'], $_POST['emergency_email'], $_POST['confirm'], $_POST['conduct']
);

if ($stmt->execute()) {
    echo "
    <div id='customAlert' class='alert-box success'>
        Player registration successful!
    </div>
    <script>
        setTimeout(function(){
            window.location.href = 'login_form.php';
        }, 1000);
    </script>
    ";
} else {
    echo "
    <div id='customAlert' class='alert-box error'>
        Error: Unable to register player.
    </div>
    <script>
        setTimeout(function(){
            window.location.href = 'login_form.php';
        }, 1000);
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
<title>XCL Player Registration</title>
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
/* Push page content down below the fixed topbar */
.content-area {
    margin-left: 250px; /* already in your code for sidebar space */
    padding-top: 80px;  /* adjust this for your topbar height (e.g. 60–100px) */
}

@media (max-width: 600px) {
    .content-area {
        margin-left: 60px;
        padding-top: 80px; /* keep same top spacing on mobile */
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

<div class="container my-2">
<h2 class="text-center mb-4">XCL Player Registration</h2>

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
        <div class="col-md-3"><label>State *</label><input type="text" name="state" class="form-control" required></div>
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
    <h5>Section 3 – Cricket Profile</h5>
    <div class="row g-3">
        <div class="col-md-4"><label>Batting Style *</label>
            <select name="batting" class="form-control" required>
                <option value="">Select</option><option>Right-hand</option><option>Left-hand</option>
            </select>
        </div>
        <div class="col-md-4"><label>Bowling Style *</label>
            <select name="bowling" class="form-control" required>
                <option value="">Select</option>
                <option>Right-arm Fast</option><option>Right-arm Medium</option><option>Right-arm Spin</option>
                <option>Left-arm Fast</option><option>Left-arm Spin</option><option>Other</option>
            </select>
        </div>
        <div class="col-md-4"><label>Primary Role *</label>
            <select name="primary_role" class="form-control" required>
                <option value="">Select</option><option>Batsman</option><option>Bowler</option><option>All-rounder</option><option>Wicketkeeper</option>
            </select>
        </div>
        <div class="col-md-4"><label>Secondary Role</label><input type="text" name="secondary_role" class="form-control"></div>
        <div class="col-md-4"><label>Experience (Years) *</label><input type="number" name="experience" class="form-control" required></div>
        <div class="col-md-4"><label>Highest Level *</label>
            <select name="highest_level" class="form-control" required>
                <option value="">Select</option><option>Club</option><option>State</option><option>National</option><option>International</option>
            </select>
        </div>
        <div class="col-md-4"><label>Current Club/Team</label><input type="text" name="current_team" class="form-control"></div>
        <div class="col-md-4"><label>Jersey Size *</label>
            <select name="jersey_size" class="form-control" required>
                <option value="">Select</option><option>S</option><option>M</option><option>L</option><option>XL</option><option>XXL</option>
            </select>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
        <button type="button" class="btn btn-primary next-btn">Next</button>
    </div>
</div>

<!-- STEP 4 -->
<div class="form-step">
    <h5>Section 4 – XCL Eligibility</h5>
    <div class="row g-3">
        <div class="col-md-4"><label>Citizen of Franchise Country? *</label><select name="citizen" class="form-control" required><option value="">Select</option><option>Yes</option><option>No</option></select></div>
        <div class="col-md-4"><label>Played in Professional T20 Leagues? *</label><select name="t20" class="form-control" required><option value="">Select</option><option>Yes</option><option>No</option></select></div>
        <div class="col-md-4"><label>Familiar with XCL Rules? *</label><select name="rules" class="form-control" required><option value="">Select</option><option>Yes</option><option>No</option></select></div>
    </div>
    <div class="mt-3 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
        <button type="button" class="btn btn-primary next-btn">Next</button>
    </div>
</div>

<!-- STEP 5 -->
<div class="form-step">
    <h5>Section 5 – Fitness & Medical</h5>
    <div class="row g-3">
        <div class="col-md-3"><label>Weight (kg) *</label><input type="number" name="weight" class="form-control" required></div>
        <div class="col-md-3"><label>Height (cm) *</label><input type="number" name="height" class="form-control" required></div>
        <div class="col-md-6"><label>Medical Conditions</label><input type="text" name="medical" class="form-control"></div>
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
        <div class="col-md-4"><label>Availability *</label><select name="availability" class="form-control" required><option value="">Select</option><option>Full season</option><option>Partial season</option><option>Specific dates</option></select></div>
        <div class="col-md-4"><label>Travel Internationally? *</label><select name="travel" class="form-control" required><option value="">Select</option><option>Yes</option><option>No</option></select></div>
        <div class="col-md-4"><label>Valid Passport? *</label><select name="passport" class="form-control" required><option value="">Select</option><option>Yes</option><option>No</option></select></div>
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
    <div class="form-check"><input class="form-check-input" type="checkbox" name="conduct" required> <label class="form-check-label">I agree to abide by XCL’s player code of conduct and anti-doping policies.</label></div>
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