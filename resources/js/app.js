require('./bootstrap');
require('axios');
import swal from 'bootstrap-sweetalert';

const url = 'https://staging.apiideraos.com'
const shipping = document.querySelector("#shipping")
const country = document.querySelector("#countryCheckout")
const state = document.querySelector("#stateCheckout")
let html = "<option value=''>Choose..</option>"

country.addEventListener('change', () => {
    const phoneAddon = document.querySelector("#phoneAddon")
    if(country.value !== '') {
        if(country.value.toLowerCase() === 'ng') {
            if(phoneAddon != null) {
                phoneAddon.style.display = 'inline-block'
            }
            axios.get(`${url}/api/delivery/states`)
            .then(res => {
                //console.log(res.data)
                const states = res.data.data
                states.forEach(state => {
                    html += `<option value="${state.code}">${state.name}</option>`
                });
                state.innerHTML = html
            })
            .catch(err => {
                console.log(err.response)
            })
        }else{
            shipping.value = 0
            if(phoneAddon != null) {
                phoneAddon.style.display = 'inline-block'
            }
            /*const states = countries.find(country => {
                return country.code2 === country.value
            }).states*/
            $('.toast').toast()
        }
        //console.log(this.states)
    }else{
        if(phoneAddon != null) {
            phoneAddon.style.display = 'inline-block'
        }
        this.states = []
    }
})

state.addEventListener('change', () => {
    if(state.value !== '') {
        const weight = document.querySelector("#cartWeight").value
        const country_code = document.querySelector("#country_code").value
        const cart_total = document.querySelector("#cart_total").value
        const total_fee = document.querySelector('#total_fee')
        const ship_fee = document.querySelector('#ship_fee')

        if(country_code.toLowerCase() === 'ng') {
            axios.get(`${url}/api/delivery/price?fromState=abv&toState=${state.value}&weight=${weight}`)
            .then(res => {
                const price = (res.data.data.price.split('.')[0]).replace(',', '')
                shipping.value = Number(price)
                ship_fee.innerHTML = Number(price).toLocaleString()
                const cartTotal = Number(cart_total.replace(',', '')) + Number(price)
                total_fee.innerHTML = cartTotal.toLocaleString()
            })
            .catch(err => {
                console.log(err.response)
            })
        }else{
            shipping.value = 0
            $('.toast').toast()
            /*this.$vs.dialog({
                color: 'primary',
                title: `!important Notice`,
                text: 'Please note that this store is not Nigerian based and as such shipping is not calculated alongside the total order. The seller will contact you about shipping costs or you can contact the seller before proceeding with the order.',
                accept: this.$vs.notify({title: 'Accepted', text: 'You have accepted to proceed with your order and be contacted later for your shipping costs', color: 'primary'})
            })*/
        }
    }
})
