const doctorSelect = document.querySelector("#doctor");
const dateInput = document.querySelector("#appointment-date");
const timeSelect = document.querySelector("#time-slot");

const flatpickrInstance = flatpickr(dateInput, {
    enable: [],
    dateFormat: "Y-m-d",
});

let appointmentsData = {};

const fetchDoctors = () => {
    fetch("/api/doctors")
        .then(response => response.json())
        .then(doctors => {
            doctors.data.forEach(doctor => {
                const option = document.createElement("option");
                option.value = doctor.id;
                option.textContent = doctor.name;
                doctorSelect.appendChild(option);
            });
        })
        .catch(error => console.log(error));
}

const fetchAppointments = (doctorId) => {
    fetch(`/api/doctor/${doctorId}/appointments`)
        .then(response => response.json())
        .then(responseData => {
            appointmentsData = responseData.data;
            const availableDates = Object.keys(appointmentsData);

            if (availableDates.length > 0) {
                flatpickrInstance.set("enable", availableDates);
                dateInput.value = availableDates[0];
                populateTimeSlots(availableDates[0]);
            } else {
                flatpickrInstance.set("enable", []);
                dateInput.value = "";
            }
        })
        .catch(error => console.log(error));
}

const populateTimeSlots = (selectedDate) => {
    timeSelect.innerHTML = "<option value=''>Select a time</option>";

    const availableAppointments = appointmentsData[selectedDate];

    if (availableAppointments && availableAppointments.length > 0) {
        availableAppointments.forEach(appointment => {
            const option = document.createElement("option");
            option.value = appointment.id;
            option.textContent = appointment.time;
            timeSelect.appendChild(option);
        });
    } else {
        const option = document.createElement("option");
        option.textContent = "No available appointments";
        timeSelect.appendChild(option);
    }
}

doctorSelect.addEventListener("change", () => {
    const doctorId = doctorSelect.value;
    console.log("Selected Doctor ID:", doctorId);

    if (doctorId) {
        fetchAppointments(doctorId);
    }
});

dateInput.addEventListener("change", () => {
    const selectedDate = dateInput.value;
    console.log("Selected Date:", selectedDate);

    if (appointmentsData[selectedDate]) {
        populateTimeSlots(selectedDate);
    }
});

fetchDoctors();
