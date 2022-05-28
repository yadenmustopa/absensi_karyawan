/**
 * @author : yaden mustopa <https://github.com/yadenmustopa
 */

"use strict";
import './app.scss';
// import './soft-ui-dashboard.scss';
import App from './App.svelte';
import jquery from 'jquery';
window.jquery = jquery;
console.log({ window });


const app = new App({ 
    target : document.getElementById("app"),
    props : {}
});

window.app    = app;

export default app;