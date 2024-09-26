// assets/bootstrap.js
import { Application } from "@hotwired/stimulus";
import { definitionsFromContext } from "@hotwired/stimulus-webpack-helpers";

// Initialize the Stimulus application
window.Stimulus = Application.start();

// Automatically load all controllers from the `assets/controllers` directory
const context = require.context("./controllers", true, /\.js$/);
Stimulus.load(definitionsFromContext(context));
