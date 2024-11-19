function clickSwitchButton() {
    document.querySelector('.UserTabBox_switch_btn__428iM').click();
    setTimeout(function () {
        putPlayerId(5195573216);

    }, 5000);
}


function putPlayerId(playerId) {
    document.querySelector('.Input_input__s4ezt input').value = playerId;
    document.querySelector('.Button_btn__P0ibl div').click();
    setTimeout(function () {
        document.querySelector('.ZoneNavBar_item__XriLM[href*="redeem"]').click();
        putRedeemCode('EpsrC4xV2a2054C6Pc')
    }, 2000);
}


function putRedeemCode(code) {
    var redeemInput = document.querySelector('.Input_input_wrap_box__Ep9yv input');

    setTimeout(function () {
        redeemInput.focus();
        redeemInput.click();
        document.querySelector('.Input_slide_box__o5GOO').classList.add('Input_active_L16rv');
        document.querySelector('.Input_input_box__aHKUS').classList.add('Input_active_L16rv');
        redeemInput.value = 'EpsrC4xV2a2054C6Pc';
    }, 3000);
}
clickSwitchButton();



