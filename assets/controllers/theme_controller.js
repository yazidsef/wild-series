import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    toggleDarkMode(event) {
        console.log('I am the toggleDarkMode method!', event)
    }
}
