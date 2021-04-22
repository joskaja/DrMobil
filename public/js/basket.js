document.querySelectorAll('.session-input').forEach(input => {
    input.addEventListener('change', function (e) {
        fetch('/basket/form-data', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                "Accept": "application/json",
                "X-CSRF-Token": document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({key: e.target.name, value: e.target.value})
        });
    });
});
document.querySelectorAll('.product-amount-input').forEach(input => {
    input.addEventListener('change', function (e) {
        console.log({basket_item_id: e.target.dataset.basket_item_id, amount: e.target.value});
        fetch('/basket/update-item', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                "Accept": "application/json",
                "X-CSRF-Token": document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({basket_item_id: e.target.dataset.basket_item_id, amount: e.target.value})
        })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'ok') {
                    if (data.new_amount < input.value) {
                        input.value = parseInt(data.new_amount);
                    }
                } else {
                    alert('Něco se nepovedlo.')
                }
            });
    })
});

// rekalkulace položek košíku

class Input {
    constructor(element) {
        this.element = element;
        this.lastVal = this.currentval;
    }
    updateVal() {
        this.lastVal = this.currentval;
    }
    get currentval() {
        return this.element.value;
    }
    sendUpdates(...parent) {
        console.log("reg");
        this.element.addEventListener("change", () => {
            setTimeout(() => {
                const balance = this.currentval - this.lastVal;
                let price = this.element.getAttribute("data-price");
                if (Array.isArray(parent)) {
                    for (const p of parent) {
                        p.refresh(balance,price);
                    }
                } else { parent.refresh(balance,price); }
                this.updateVal()
            }, 50)

        });
    }
}

class Price {
    constructor(element) {
        this.element = element;
    }
    get price() {
        let number = this.element.innerText;
        number = number.replaceAll(/[^,\d]/gi, '');
        number = number.replaceAll(',', '.');
        return parseFloat(number);
    }
    updatePrice(value) {
        let price = value.toLocaleString('cs-CZ', {style: 'currency', currency: 'CZK', });
        this.element.innerText = price;
    }
    refresh(quantity = 1, value = 0) {
        let price = quantity * value;
        this.updatePrice(this.price + price);
    }
}
class PriceInt extends Price {
    constructor(element) {
        super(element);
    }
    updatePrice(value) {
        let price = value.toLocaleString('cs-CZ', {style: 'currency', currency: 'CZK', maximumFractionDigits: 0});
        this.element.innerText = price;
    }
}
// class Quant {
//     constructor(element) {
//         this.element = element;
//     }
//     get quantity() {
//         return this.element.getAttribute("data-basket");
//     }
//     refresh(quantity = 1, price = 0) {
//         let value = Number.parseInt(this.quantity) + quantity;
//         this.element.setAttribute("data-basket", value)
//     }
// }
const nav = new PriceInt(document.querySelector(".navbar .nav-anchor .namen"));
const total = new Price(document.querySelector("#total-price strong"));
// const navAmount = new Quant(document.querySelector(".nav-anchor[data-basket]"));
const amounts = document.querySelectorAll("#basket-items input");
const amount = [];
for (let i = 0; i < amounts.length; i++) {
    amount[i] = new Input(amounts[i]);
    amount[i].sendUpdates(total, nav);
}
console.log(total.price);
