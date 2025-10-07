/**
 *  Form Wizard
 */

"use strict"

$(function () {
    // const select2 = $(".select2"),
    //     selectPicker = $(".selectpicker")
    // // Bootstrap select
    // if (selectPicker.length) {
    //     selectPicker.selectpicker()
    //     handleBootstrapSelectEvents()
    // }
    // // Select2
    // if (select2.length) {
    //     select2.each(function () {
    //         const $this = $(this)
    //         select2Focus($this)
    //         $this.wrap('<div class="position-relative"></div>')
    //         $this.select2({
    //             placeholder: "Select value",
    //             dropdownParent: $this.parent(),
    //         })
    //     })
    // }
})
;(function () {
    // Numbered Wizard
    // --------------------------------------------------------------------
    const wizardNumbered = document.querySelector(".wizard-numbered")
    if (wizardNumbered) {
        const wizardNumberedBtnNextList = [].slice.call(wizardNumbered.querySelectorAll(".btn-next")),
            wizardNumberedBtnPrevList = [].slice.call(wizardNumbered.querySelectorAll(".btn-prev")),
            wizardNumberedBtnSubmit = wizardNumbered.querySelector(".btn-submit")

        const numberedStepper = new Stepper(wizardNumbered, { linear: false })
        wizardNumbered.stepper = numberedStepper

        wizardNumberedBtnNextList.forEach((btn) => {
            btn.addEventListener("click", () => numberedStepper.next())
        })

        wizardNumberedBtnPrevList.forEach((btn) => {
            btn.addEventListener("click", () => numberedStepper.previous())
        })

        if (wizardNumberedBtnSubmit) {
            wizardNumberedBtnSubmit.addEventListener("click", () => {
                alert("Submitted..!!")
            })
        }
    }

    // Vertical Wizard
    // --------------------------------------------------------------------
    const wizardVertical = document.querySelector(".wizard-vertical")
    if (wizardVertical) {
        const wizardVerticalBtnNextList = [].slice.call(wizardVertical.querySelectorAll(".btn-next")),
            wizardVerticalBtnPrevList = [].slice.call(wizardVertical.querySelectorAll(".btn-prev")),
            wizardVerticalBtnSubmit = wizardVertical.querySelector(".btn-submit")

        const verticalStepper = new Stepper(wizardVertical, { linear: false })

        wizardVerticalBtnNextList.forEach((btn) => {
            btn.addEventListener("click", () => verticalStepper.next())
        })

        wizardVerticalBtnPrevList.forEach((btn) => {
            btn.addEventListener("click", () => verticalStepper.previous())
        })

        if (wizardVerticalBtnSubmit) {
            wizardVerticalBtnSubmit.addEventListener("click", () => {
                alert("Submitted..!!")
            })
        }
    }

    // Modern Wizard
    // --------------------------------------------------------------------
    const wizardModern = document.querySelector(".wizard-modern-example")
    if (wizardModern) {
        const wizardModernBtnNextList = [].slice.call(wizardModern.querySelectorAll(".btn-next")),
            wizardModernBtnPrevList = [].slice.call(wizardModern.querySelectorAll(".btn-prev")),
            wizardModernBtnSubmit = wizardModern.querySelector(".btn-submit")

        const modernStepper = new Stepper(wizardModern, { linear: false })

        wizardModernBtnNextList.forEach((btn) => {
            btn.addEventListener("click", () => modernStepper.next())
        })

        wizardModernBtnPrevList.forEach((btn) => {
            btn.addEventListener("click", () => modernStepper.previous())
        })

        if (wizardModernBtnSubmit) {
            wizardModernBtnSubmit.addEventListener("click", () => {
                alert("Submitted..!!")
            })
        }
    }

    // Modern Vertical Wizard
    // --------------------------------------------------------------------
    const wizardModernVertical = document.querySelector(".wizard-modern-vertical")
    if (wizardModernVertical) {
        const wizardModernVerticalBtnNextList = [].slice.call(wizardModernVertical.querySelectorAll(".btn-next")),
            wizardModernVerticalBtnPrevList = [].slice.call(wizardModernVertical.querySelectorAll(".btn-prev")),
            wizardModernVerticalBtnSubmit = wizardModernVertical.querySelector(".btn-submit")

        const modernVerticalStepper = new Stepper(wizardModernVertical, { linear: false })

        wizardModernVerticalBtnNextList.forEach((btn) => {
            btn.addEventListener("click", () => modernVerticalStepper.next())
        })

        wizardModernVerticalBtnPrevList.forEach((btn) => {
            btn.addEventListener("click", () => modernVerticalStepper.previous())
        })

        if (wizardModernVerticalBtnSubmit) {
            wizardModernVerticalBtnSubmit.addEventListener("click", () => {
                alert("Submitted..!!")
            })
        }
    }
})()
