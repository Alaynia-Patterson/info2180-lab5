document.addEventListener("DOMContentLoaded", () => {
    const lookupCountryButton = document.getElementById("lookup-country");
    const lookupCitiesButton = document.getElementById("lookup-cities");
    const resultDiv = document.getElementById("result");

    // Fetch data from the server and update the UI
    const fetchData = (url) => {
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.text();
            })
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                resultDiv.innerHTML = `<p>Error fetching data: ${error.message}</p>`;
            });
    };

    // Handle Lookup Country
    lookupCountryButton.addEventListener("click", () => {
        const countryInput = document.getElementById("country").value.trim();
        if (countryInput) {
            const url = `world.php?country=${encodeURIComponent(countryInput)}`;
            fetchData(url);
        } else {
            resultDiv.innerHTML = `<p>Please enter a country name.</p>`;
        }
    });

    // Handle Lookup Cities
    lookupCitiesButton.addEventListener("click", () => {
        const countryInput = document.getElementById("country").value.trim();
        if (countryInput) {
            const url = `world.php?country=${encodeURIComponent(countryInput)}&lookup=cities`;
            fetchData(url);
        } else {
            resultDiv.innerHTML = `<p>Please enter a country name.</p>`;
        }
    });
});