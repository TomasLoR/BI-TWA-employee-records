async function deleteAccount(apiUrl, accountElement) {
    try {
        const response = await fetch(apiUrl, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        });
        validateResponse(response);

        const data = await response.json();
        console.log('Účet úspěšně smazán:', data);

        accountElement.remove();
    } catch (error) {
        console.error('Účet se nepovedlo smazat:', error);
    }
}

function validateResponse(response) {
    if (!response.ok) {
        throw new Error(`${response.status} - ${response.statusText}`);
    }
}
