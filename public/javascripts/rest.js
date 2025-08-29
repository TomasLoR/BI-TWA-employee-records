class Rest {
    #formElement = undefined;
    #contentElement = undefined;

    constructor(formElement, contentElement) {
        this.#formElement = formElement;
        this.#contentElement = contentElement;

        this.#formElement.addEventListener('submit', (event) => this.#handleFormSubmit(event));
    }

    async #handleFormSubmit(event) {
        event.preventDefault();

        const form = this.#formElement.querySelector('form');
        const apiUrl = this.#formElement.dataset.rest;
        const formData = this.#retrieveFormData(form);

        try {
            const response = await fetch(apiUrl, {
                method: form.dataset.method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(formData),
            });
            this.#validateResponse(response);

            const result = await response.json();
            this.#addAccountToList(result);
            form.reset();
        } catch (error) {
            console.error(error);
        }
    }

    #retrieveFormData(form) {
        const formName = form.getAttribute('name');
        const formRegex = new RegExp(`^${formName}\\[(.+)\\]`);

        let data = {};
        const formData = new FormData(form);

        formData.forEach((value, key) => {
            const match = key.match(formRegex);

            if (!match || key.includes('_token')) {
                return;
            }

            const name = match[1];
            data[name] = value === "" ? null : value;
        });

        return data;
    }

    #validateResponse(response) {
        if (!response.ok) {
            throw new Error(`${response.status} - ${response.statusText}`);
        }
    }

    #addAccountToList(account) {
        // TODO
    }
}

const formElement = document.querySelector('.form-outside');
const contentElement = document.querySelector('.account-list');

const rest = new Rest(formElement, contentElement);
