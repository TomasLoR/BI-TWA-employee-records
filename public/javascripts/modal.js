class Modal {

    #element = undefined;
    #message = undefined;
    #confirmBtn = undefined;
    #cancelBtn = undefined;
    #callback = undefined;

    constructor(message, callback) {
        this.#message = message;
        this.#callback = callback;

        this.#create();
        this.#addEventListeners();
    }

    #create() {
        this.#element = this.#createModalElement();
        this.#element.appendChild(this.#createModalContent());
        this.#element.appendChild(this.#createButtons('Potvrdit', 'Zrušit'));
        document.body.appendChild(this.#element);
    }

    #createModalElement() {
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.setAttribute('role', 'dialog');

        return modal;
    }

    #createModalContent() {
        const modalContent = document.createElement('div');
        modalContent.className = 'modal-content';

        const contentParagraph = document.createElement('p');
        contentParagraph.textContent = this.#message;

        modalContent.appendChild(contentParagraph);
        return modalContent;
    }

    #createButtons(confirmText, cancelText) {
        const buttonContainer = document.createElement('div');
        buttonContainer.className = 'modal-buttons';

        this.#confirmBtn = document.createElement('button');
        this.#confirmBtn.className = 'button';
        this.#confirmBtn.textContent = confirmText;

        this.#cancelBtn = document.createElement('button');
        this.#cancelBtn.className = 'button';
        this.#cancelBtn.textContent = cancelText;

        buttonContainer.appendChild(this.#confirmBtn);
        buttonContainer.appendChild(this.#cancelBtn);

        return buttonContainer;
    }

    #addEventListeners() {
        document.addEventListener('click', (e) => this.#handleOutsideClick(e));
        document.addEventListener('keydown', (e) => this.#handleKeyPress(e));

        this.#confirmBtn.addEventListener('click', () => this.#confirm());
        this.#cancelBtn.addEventListener('click', () => this.#cancel());
    }

    #confirm() {
        if (this.#callback) {
            this.#callback();
        }
        this.#element.remove();
    }

    #cancel() {
        this.hide();
    }

    #handleOutsideClick(e) {
        if (e.target === this.#element) {
            this.#cancel();
        }
    }

    #handleKeyPress(e) {
        if (e.key === 'Enter') {
            this.#confirm();
        } else if (e.key === 'Escape') {
            this.#cancel();
        }
    }

    hide() {
        this.#element.classList.add('hidden');
    }

    show() {
        this.#element.classList.remove('hidden');
    }
}


const modalTriggers = document.querySelectorAll('[data-toggle="modal"]');
modalTriggers.forEach((element) => {

    let modal = null;
    element.addEventListener('click', () => {
        if (!modal) {
            const apiUrl = `/api/employees/${element.dataset.employeeId}/accounts/${element.dataset.accountId}`;
            const accountElement = document.querySelector(`.account-item[data-account-id="${element.dataset.accountId}"]`);
            modal = new Modal(
                element.dataset.message,
                () => deleteAccount(
                    apiUrl,
                    accountElement
                )
            );        
        }
        modal.show();
    });
});