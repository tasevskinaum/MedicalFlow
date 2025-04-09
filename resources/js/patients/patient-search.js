document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("patient");
    const patientElements = document.querySelectorAll(".patients .patient");

    const patients = Array.from(patientElements).map((el) => {
        const spans = el.querySelectorAll("span");
        return {
            element: el,
            firstName: spans[0].textContent.toLowerCase().split(" ")[0],
            lastName: spans[0].textContent.toLowerCase().split(" ")[1] || "",
            personalNo: spans[1].textContent.toLowerCase(),
        };
    });

    searchInput.addEventListener("input", () => {
        const query = searchInput.value.toLowerCase().trim();

        patients.forEach(({
            element,
            firstName,
            lastName,
            personalNo
        }) => {
            const fullName = `${firstName} ${lastName}`;
            if (
                firstName.includes(query) ||
                lastName.includes(query) ||
                fullName.includes(query) ||
                personalNo.includes(query)
            ) {
                element.style.display = "";
            } else {
                element.style.display = "none";
            }
        });
    });
});