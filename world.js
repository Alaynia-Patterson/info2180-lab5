document.addEventListener("DOMContentLoaded", () => {
    const lookupButton = document.getElementById("lookup");
    const resultDiv = document.getElementById("result");

    lookupButton.addEventListener("click", () => {
        const countryInput = document.getElementById("country").value;
        const url = `world.php?country=${encodeURIComponent(countryInput)}`;

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
    });
});
