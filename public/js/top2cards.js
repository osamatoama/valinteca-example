// cart Page

function generateRandomString(length) {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    let counter = 0;
    while (counter < length) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
        counter += 1;
    }
    return result;
}


if (window.location.href.includes('cart')) {
    console.log('cart page');
    var cartItems = document.querySelectorAll('.cart-item h3 a.text-base'),
        containsSawa = false;
    window.sessionStorage.setItem('containsSawa', 0);

    cartItems.forEach(function (item) {
        if (item.innerText.includes('شحن سوا')) {
            window.sessionStorage.setItem('containsSawa', 1);
        }
    });
}

if (window.location.href.includes('checkout')) {
    console.log('checkout page');
    if (window.sessionStorage.getItem('containsSawa') == '1') {

    }
}


if (window.location.href.includes('thankyou')) {

    if (window.sessionStorage.getItem('containsSawa') == '1') {
        var orderId = document.querySelector('salla-button.code-to-copy').dataset.content,
            randomString = generateRandomString(130);

        if (orderId) {
            window.location.href = ''// top2cards.valantica.com/randomString/orderId
        }
    } else {
        fetch('https://example.valinteca.com/api/top2cards-fetch-stc-order', {
            body: {
                orderId: orderId
            },
            headers: {
                "Content-Type": "application/json",
            }
        }).then(function (data) {
            return data.json()
        }).then(data => {
            if (data.success == true) {
                console.log("Redirect")
                window.location.href = ''// top2cards.valantica.com/randomString/orderId
            } else {
                console.log("Nothing to Do ")
            }
        });
    }
}

// اسالة للعميل
// هل الثيم راح يتغير
// هل اسماء المنتجات تتغير
// هل التاغ مانجر راح يتغير


// tag manager page trigger

// (cart|checkout|thankyou)
