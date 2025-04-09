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