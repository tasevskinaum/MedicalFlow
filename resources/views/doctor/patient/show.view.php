<!DOCTYPE html>
<html>

<head>
    <?php require_once BASE_PATH . '/resources/views/partials/_head.view.php' ?>
</head>

<body>
    <div class="app">
        <div class="content-area">
            <?php require_once BASE_PATH . '/resources/views/admin/partials/sidebar.php' ?>
            <div class="main-content-area">
                <?php require_once BASE_PATH . '/resources/views/admin/partials/header.php' ?>
                <main>
                    <div class="patient-history">
                        <div class="title">
                            <h2>Patient History</h2>
                        </div>

                        <div class="patient-info">
                            <div>Name: <span><?= $patient->first_name ?> <?= $patient->last_name ?></span></div>
                            <div>Personal No.: <span><?= $patient->personal_no ?></span></div>
                            <div>Phone number: <span><?= $patient->phone_number ?></span></div>
                        </div>

                        <div class="history">
                            <div class="title">
                                <h3>History</h3>
                            </div>

                            <?php foreach ($patientHistory as $index => $history): ?>
                                <div class="history-entry" id="entry-<?= $index ?>">
                                    <div>Date: <span><?= $history['date'] ?></span></div>
                                    <div>Doctor: <span><?= $history['doctor_name'] ?></span></div>
                                    <div>Diagnosis: <span><?= $history['diagnosis'] ?></span></div>
                                    <div class="actions">
                                        <button onclick="printEntry('entry-<?= $index ?>')">Print</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <script type="module" src="/resources/js/top-bar.js"></script>
    <script type="module" src="/resources/js/sidebar.js"></script>
    <script type="module" src="/resources/js/patients/patient-search.js"></script>
    <script>
        function printEntry(entryId) {
            const entry = document.getElementById(entryId).cloneNode(true);

            const printWindow = window.open('', '', 'width=800,height=600');

            printWindow.document.write(`
            <html>
                <head>
                    <title>Patient <?= $patient->first_name ?> <?= $patient->last_name ?></title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 20px; }
                        .actions { display: none; }
                    </style>
                </head>
                <body>
                    <h2>Medical Flow</h2>
                    <div>
                        <div>Name: <span><?= $patient->first_name ?> <?= $patient->last_name ?></span></div>
                        <div>Personal No.: <span><?= $patient->personal_no ?></span></div>
                        <div>Phone number: <span><?= $patient->phone_number ?></span></div>
                    </div>
                    <hr>
                    ${entry.outerHTML}
                </body>
            </html>
        `);

            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    </script>

</body>

</html>