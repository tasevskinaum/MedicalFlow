document.getElementById("next-button").addEventListener("click", function () {
    document.getElementById("step-1").style.display = "none";
    document.getElementById("step-2").style.display = "block";
});

document.getElementById("prev-button-1").addEventListener("click", function () {
    document.getElementById("step-2").style.display = "none";
    document.getElementById("step-1").style.display = "block";
});

document.getElementById("preview-button").addEventListener("click", function () {
    document.getElementById("preview-first-name").innerText = document.getElementById("first-name").value;
    document.getElementById("preview-last-name").innerText = document.getElementById("last-name").value;
    document.getElementById("preview-personal-no").innerText = document.getElementById("personal-no").value;
    document.getElementById("preview-phone-number").innerText = document.getElementById("phone-number").value;
    document.getElementById("preview-note").innerText = document.getElementById("note").value;
    document.getElementById("preview-doctor").innerText =
        document.getElementById("doctor").options[document.getElementById("doctor").selectedIndex].innerText;
    document.getElementById("preview-date").innerText = document.getElementById("appointment-date").value;
    document.getElementById("preview-time").innerText =
        document.getElementById("time-slot").options[document.getElementById("time-slot").selectedIndex].innerText;

    document.getElementById("step-2").style.display = "none";
    document.getElementById("step-3").style.display = "block";
});

document.getElementById("prev-button-2").addEventListener("click", function () {
    document.getElementById("step-3").style.display = "none";
    document.getElementById("step-2").style.display = "block";
});
