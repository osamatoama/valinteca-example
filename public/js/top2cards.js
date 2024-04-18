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
    window.localStorage.setItem('containsSawa', 0);

    cartItems.forEach(function (item) {
        if (item.innerText.includes('شحن سوا')) {
            window.localStorage.setItem('containsSawa', 1);
        }
    });
}

if (window.location.href.includes('checkout')) {
    console.log('checkout page');
    if (window.localStorage.getItem('containsSawa') == '1') {

    }
}


if (window.location.href.includes('thankyou')) {

    if (window.localStorage.getItem('containsSawa') == '1') {
        var orderId = document.querySelector('salla-button.code-to-copy').dataset.content;
        var randomString = generateRandomString(26);

        window.location.href = ''// top2cards.valantica.com/randomString/orderId
    } else {
        fetch('https://example.valinteca.com/api/top2cards-fetch-non-stc-order', {
            headers: {
                "Content-Type": "application/json",
            }
        }).then(function (data) {
            console.log(data);
        })
    }
}


// هل الثيم راح يتغير
// هل اسماء المنتجات تتغير
