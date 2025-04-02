<!DOCTYPE html>
<html>

<head>
    <?php require_once BASE_PATH . '/resources/views/partials/_head.view.php' ?>
</head>

<body>
    <div class="app">
        <?php require_once BASE_PATH . '/resources/views/home/partials/header.view.php' ?>
        <main class="request-an-appointment-main">
            <div class="request-an-appointment">
                <form id="request-an-appointment-form">
                    <div id="step-1">
                        <div class="form-control">
                            <label for="first-name">First Name</label>
                            <input type="text" name="first-name" id="first-name">
                        </div>
                        <div class="form-control">
                            <label for="last-name">Last Name</label>
                            <input type="text" name="last-name" id="last-name">
                        </div>
                        <div class="form-control">
                            <label for="personal-no">Personal No.</label>
                            <input type="text" name="personal-no" id="personal-no">
                        </div>
                        <div class="form-control">
                            <label for="phone-number">Phone Number</label>
                            <input type="tel" name="phone-number" id="phone-number">
                        </div>
                        <div class="form-control">
                            <label for="note">Note:</label>
                            <textarea name="note" id="note"></textarea>
                        </div>
                        <div class="form-control">
                            <button type="button" id="next-button" class="form-btn">Next</button>
                        </div>
                    </div>

                    <div id="step-2" style="display: none;">
                        <div class="form-control">
                            <label for="doctor">Choose doctor:</label>
                            <select name="doctor" id="doctor">
                                <option disabled selected>Choose doctor..</option>
                            </select>
                        </div>
                        <div class="form-control">
                            <label for="appointment-date">Pick date:</label>
                            <input type="date" name="appointment-date" id="appointment-date">
                        </div>
                        <div class="form-control">
                            <label for="time-slot">Choose time:</label>
                            <select name="time-slot" id="time-slot">
                                <option disabled selected>Choose time..</option>
                            </select>
                        </div>
                        <div class="form-control">
                            <button type="button" id="prev-button-1" class="form-btn">Back</button>
                            <button type="button" id="preview-button" class="form-btn">preview and confirm</button>
                        </div>
                    </div>

                    <div id="step-3" style="display: none;">
                        <h3>Preview Your Appointment</h3>
                        <p><strong>First Name:</strong> <span id="preview-first-name"></span></p>
                        <p><strong>Last Name:</strong> <span id="preview-last-name"></span></p>
                        <p><strong>Personal No.:</strong> <span id="preview-personal-no"></span></p>
                        <p><strong>Phone Number:</strong> <span id="preview-phone-number"></span></p>
                        <p><strong>Note:</strong> <span id="preview-note"></span></p>
                        <p><strong>Doctor:</strong> <span id="preview-doctor"></span></p>
                        <p><strong>Date:</strong> <span id="preview-date"></span></p>
                        <p><strong>Time Slot:</strong> <span id="preview-time"></span></p>
                        <div class="form-control">
                            <button type="button" id="prev-button-2" class="form-btn">Back</button>
                            <input type="submit" value="Confirm Appointment">
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php require_once BASE_PATH . '/resources/views/partials/_script.view.php' ?>
    <script type="module" src="/resources/js/navbar-toggle.js"></script>
    <script type="module" src="/resources/js/request-an-appointment/index.js"></script>
    <script type="module" src="/resources/js/request-an-appointment/step-navigation.js"></script>
    <script type="module" src="/resources/js/request-an-appointment/formSubmission.js"></script>

</body>

</html>