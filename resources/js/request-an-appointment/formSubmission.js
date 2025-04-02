document.querySelector("#request-an-appointment-form").addEventListener('submit', async (e) => {
    e.preventDefault();
    const doctor = document.querySelector("#doctor").value;
    const appointment = document.querySelector("#time-slot").value;
    const form = document.querySelector("#request-an-appointment-form");
    const formData = new FormData(form);

    try {
        const response = await fetch(`/api/doctor/${doctor}/appointments/${appointment}`, {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            Swal.fire({
                title: 'Oops!',
                text: `An unexpected error occurred. Please try again later.`,
                icon: 'error',
                confirmButtonText: 'Close',
                customClass: {
                    confirmButton: 'swal2-btn-sm'
                },
                buttonsStyling: false,
            });

            return;
        }

        const responseData = await response.json();

        if (responseData.error) {
            document.getElementById("step-1").style.display = "block";
            document.getElementById("step-2").style.display = "none";
            document.getElementById("step-3").style.display = "none";

            Object.keys(responseData.error).forEach(field => {
                const fieldElement = document.querySelector(`[name="${field}"]`);

                if (fieldElement) {
                    const previousErrors = fieldElement.parentNode.querySelectorAll('.fdb.error');
                    previousErrors.forEach(errorSpan => errorSpan.remove());

                    const errorSpan = document.createElement("span");
                    errorSpan.classList.add("fdb", "error");

                    let formattedField = field
                        .replace(/-/g, ' ')
                        .replace(/\b\w/g, char => char.toUpperCase());

                    errorSpan.textContent = `${formattedField} ${responseData.error[field][0].replace(field, "").trim()}`;
                    fieldElement.parentNode.appendChild(errorSpan);
                }
            });

            return;
        }

        form.reset();

        Swal.fire({
            title: 'Success!',
            text: responseData.message || 'Your appointment has been successfully scheduled!',
            icon: 'success',
            confirmButtonText: 'Close',
            customClass: {
                confirmButton: 'swal2-btn-sm'
            },
            buttonsStyling: false,
        }).then(() => {
            window.location.href = '/';
        });

    } catch (error) {
        Swal.fire({
            title: 'Error!',
            text: 'An unexpected error occurred. Please check your internet connection or try again later.',
            icon: 'error',
            customClass: {
                confirmButton: 'swal2-btn-sm'
            },
            buttonsStyling: false,
            confirmButtonText: 'Close',
        });
    }
});
