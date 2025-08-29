class Dropdown {
    #element = undefined;
    #trigger = undefined;
    #menu = undefined;
    #hidden = undefined;

    constructor(element) {
        this.#element = element;
        this.#trigger = element.querySelector('.dropdown-trigger');
        this.#menu = element.querySelector('.dropdown-menu');
        this.#addEventListeners();
    }

    #addEventListeners() {
        this.#trigger.addEventListener('click', () => this.#toggleMenu());
        document.addEventListener('click', (e) => this.#handleOutsideClick(e));
    }

    #toggleMenu() {
        if (this.#hidden) {
            this.show();
        } else {
            this.hide();
        }
    }

    #handleOutsideClick(e) {
        if (!this.#element.contains(e.target)) {
            this.hide();
        }
    }

    show() {
        this.#menu.classList.remove('hidden');
        this.#hidden = false;
    }

    hide() {
        this.#menu.classList.add('hidden');
        this.#hidden = true;
    }
}


const dropdownNavigations = document.querySelectorAll('[data-toggle="dropdown"]');
dropdownNavigations.forEach((element) => {
    let dropdown = new Dropdown(element);
    dropdown.hide();
});