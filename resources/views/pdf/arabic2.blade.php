<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Valinteca - ticket</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Dastnevis', sans-serif;
            background-color: #1e1e1e;
            padding: 0 15px;
            text-align: center;
            min-height: 100vh;
        }

        .main-row span {
            display: block;
        }

        table {
            border-collapse: collapse;
            margin: auto;
            width: 100%;
        }

        .wrapper {
            overflow: hidden;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .ellipse {
            background-color: #1e1e1e;
            border-radius: 50%;
        }

        .ellipse-lg {
            width: 40px;
            height: 40px;
            position: absolute;
        }

        .ellipse-sm {
            width: 30px;
            height: 30px;
        }

        .head-row {
            background-color: #222222;
            padding: 6px;
        }

        .part-1 .ellipse-lg {
            top: 50%;
            transform: translateY(-50%);
            right: -20px;
            background-color: #1e1e1e;
        }

        .part-2 {
            background-color: #fff;
            border-left: 2px dashed #000;
            padding: 20px;
            width: 100%;
        }

        .info-item {
            margin-bottom: 10px;
        }

        .info-item span {
            font-weight: 700;
            display: block;
        }

        .part-3 {
            background-color: #f5f0ea;
            max-width: 150px;
            text-align: center;
            padding: 0 25px;
            padding: 20px;
        }

        .part-4 {
            background-color: #f5f0ea;
        }
    </style>
</head>
<body>
<table
    style="width: 600px; margin: 30px 0"
    class="wrapper"
    role="presentation"
>
    <tr>
        <td class="part-2">
            <table cellspacing="0" cellpadding="0" role="presentation">
                <colgroup>
                    <col/>
                    <col style="width: 100px"/>
                </colgroup>

                <tr style="height: 30px;" class="head-row">
                    <td style="padding: 8px;">
                        <span style="color: #fff; margin: 0 5px">رقم التذكرة:</span>
                    </td>
                    <td style="padding: 8px;">
                        <span style="color: #fff; margin: 0 5px">01000000</span>
                    </td>
                </tr>

                <tr style="height: 25px"></tr>

                <tr class="main-row">
                    <td>
                <span
                    style="
                    font-size: 36px;
                    font-weight: 700;
                    margin-bottom: 1.5rem;
                  "
                >حفلة العام المميزة</span
                >
                    </td>
                    <td>
                        <img
                            src="./ticket/images/logo.png"
                            alt="valinteca-logo"
                            style="max-height: 90px; max-width: 80px; object-fit: contain"
                        />
                    </td>
                </tr>

                <tr>
                    <td>
                <span
                    style="
                    display: block;
                    padding: 12px 32px;
                    background-color: #f5f0ea;
                    font-weight: 700;
                    text-align: center;
                    word-spacing: 4px;
                  "
                >14 اكتوبر, 2025</span
                >
                    </td>
                </tr>

                <tr style="height: 25px"></tr>

                <tr>
                    <td>
                        <table>
                            <tr>
                                <td class="info-item">
                                    <span>الوقت:</span>
                                    <small
                                        style="
                          font-weight: 600;
                          font-size: 12px;
                          display: block;
                        "
                                    >4:00 مساءاً</small
                                    >
                                </td>
                                <td class="info-item">
                                    <span>السعر:</span>
                                    <small
                                        style="
                          font-weight: 600;
                          font-size: 12px;
                          display: block;
                        "
                                    >7000 $</small
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td class="info-item" colspan="2">
                                    <span>العنوان:</span>
                                    <small
                                        style="
                          font-weight: 600;
                          font-size: 12px;
                          display: block;
                        "
                                    >ستوديو اّدم,<br/>شارع المدينة , جدة , السعودية</small
                                    >
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <img
                            src="./ticket/images/qr-code.png"
                            alt="qr-code"
                            style="max-height: 90px; max-width: 80px; object-fit: contain"
                        />
                    </td>
                </tr>
            </table>
        </td>

        <td class="part-3">
            <table>
                <colgroup>
                    <col style="width: 60px"/>
                    <col/>
                </colgroup>

                <tr>
                    <td class="serial-code">
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                    </td>
                    <td
                        style="
                  font-weight: 700;
                  font-size: 24px;
                  transform: rotate(90deg);
                  margin-top: 20px;
                "
                    >
                        مميز
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
    <table
    style="width: 600px; margin: 30px 0"
    class="wrapper"
    role="presentation"
>
    <tr>
        <td class="part-2">
            <table cellspacing="0" cellpadding="0" role="presentation">
                <colgroup>
                    <col/>
                    <col style="width: 100px"/>
                </colgroup>

                <tr style="height: 30px;" class="head-row">
                    <td style="padding: 8px;">
                        <span style="color: #fff; margin: 0 5px">رقم التذكرة:</span>
                    </td>
                    <td style="padding: 8px;">
                        <span style="color: #fff; margin: 0 5px">01000000</span>
                    </td>
                </tr>

                <tr style="height: 25px"></tr>

                <tr class="main-row">
                    <td>
                <span
                    style="
                    font-size: 36px;
                    font-weight: 700;
                    margin-bottom: 1.5rem;
                  "
                >حفلة العام المميزة</span
                >
                    </td>
                    <td>
                        <img
                            src="./ticket/images/logo.png"
                            alt="valinteca-logo"
                            style="max-height: 90px; max-width: 80px; object-fit: contain"
                        />
                    </td>
                </tr>

                <tr>
                    <td>
                <span
                    style="
                    display: block;
                    padding: 12px 32px;
                    background-color: #f5f0ea;
                    font-weight: 700;
                    text-align: center;
                    word-spacing: 4px;
                  "
                >14 اكتوبر, 2025</span
                >
                    </td>
                </tr>

                <tr style="height: 25px"></tr>

                <tr>
                    <td>
                        <table>
                            <tr>
                                <td class="info-item">
                                    <span>الوقت:</span>
                                    <small
                                        style="
                          font-weight: 600;
                          font-size: 12px;
                          display: block;
                        "
                                    >4:00 مساءاً</small
                                    >
                                </td>
                                <td class="info-item">
                                    <span>السعر:</span>
                                    <small
                                        style="
                          font-weight: 600;
                          font-size: 12px;
                          display: block;
                        "
                                    >7000 $</small
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td class="info-item" colspan="2">
                                    <span>العنوان:</span>
                                    <small
                                        style="
                          font-weight: 600;
                          font-size: 12px;
                          display: block;
                        "
                                    >ستوديو اّدم,<br/>شارع المدينة , جدة , السعودية</small
                                    >
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <img
                            src="./ticket/images/qr-code.png"
                            alt="qr-code"
                            style="max-height: 90px; max-width: 80px; object-fit: contain"
                        />
                    </td>
                </tr>
            </table>
        </td>

        <td class="part-3">
            <table>
                <colgroup>
                    <col style="width: 60px"/>
                    <col/>
                </colgroup>

                <tr>
                    <td class="serial-code">
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                    </td>
                    <td
                        style="
                  font-weight: 700;
                  font-size: 24px;
                  transform: rotate(90deg);
                  margin-top: 20px;
                "
                    >
                        مميز
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

    <table
    style="width: 600px; margin: 30px 0"
    class="wrapper"
    role="presentation"
>
    <tr>
        <td class="part-2">
            <table cellspacing="0" cellpadding="0" role="presentation">
                <colgroup>
                    <col/>
                    <col style="width: 100px"/>
                </colgroup>

                <tr style="height: 30px;" class="head-row">
                    <td style="padding: 8px;">
                        <span style="color: #fff; margin: 0 5px">رقم التذكرة:</span>
                    </td>
                    <td style="padding: 8px;">
                        <span style="color: #fff; margin: 0 5px">01000000</span>
                    </td>
                </tr>

                <tr style="height: 25px"></tr>

                <tr class="main-row">
                    <td>
                <span
                    style="
                    font-size: 36px;
                    font-weight: 700;
                    margin-bottom: 1.5rem;
                  "
                >حفلة العام المميزة</span
                >
                    </td>
                    <td>
                        <img
                            src="./ticket/images/logo.png"
                            alt="valinteca-logo"
                            style="max-height: 90px; max-width: 80px; object-fit: contain"
                        />
                    </td>
                </tr>

                <tr>
                    <td>
                <span
                    style="
                    display: block;
                    padding: 12px 32px;
                    background-color: #f5f0ea;
                    font-weight: 700;
                    text-align: center;
                    word-spacing: 4px;
                  "
                >14 اكتوبر, 2025</span
                >
                    </td>
                </tr>

                <tr style="height: 25px"></tr>

                <tr>
                    <td>
                        <table>
                            <tr>
                                <td class="info-item">
                                    <span>الوقت:</span>
                                    <small
                                        style="
                          font-weight: 600;
                          font-size: 12px;
                          display: block;
                        "
                                    >4:00 مساءاً</small
                                    >
                                </td>
                                <td class="info-item">
                                    <span>السعر:</span>
                                    <small
                                        style="
                          font-weight: 600;
                          font-size: 12px;
                          display: block;
                        "
                                    >7000 $</small
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td class="info-item" colspan="2">
                                    <span>العنوان:</span>
                                    <small
                                        style="
                          font-weight: 600;
                          font-size: 12px;
                          display: block;
                        "
                                    >ستوديو اّدم,<br/>شارع المدينة , جدة , السعودية</small
                                    >
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <img
                            src="./ticket/images/qr-code.png"
                            alt="qr-code"
                            style="max-height: 90px; max-width: 80px; object-fit: contain"
                        />
                    </td>
                </tr>
            </table>
        </td>

        <td class="part-3">
            <table>
                <colgroup>
                    <col style="width: 60px"/>
                    <col/>
                </colgroup>

                <tr>
                    <td class="serial-code">
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                    </td>
                    <td
                        style="
                  font-weight: 700;
                  font-size: 24px;
                  transform: rotate(90deg);
                  margin-top: 20px;
                "
                    >
                        مميز
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

    <table
    style="width: 600px; margin: 30px 0"
    class="wrapper"
    role="presentation"
>
    <tr>
        <td class="part-2">
            <table cellspacing="0" cellpadding="0" role="presentation">
                <colgroup>
                    <col/>
                    <col style="width: 100px"/>
                </colgroup>

                <tr style="height: 30px;" class="head-row">
                    <td style="padding: 8px;">
                        <span style="color: #fff; margin: 0 5px">رقم التذكرة:</span>
                    </td>
                    <td style="padding: 8px;">
                        <span style="color: #fff; margin: 0 5px">01000000</span>
                    </td>
                </tr>

                <tr style="height: 25px"></tr>

                <tr class="main-row">
                    <td>
                <span
                    style="
                    font-size: 36px;
                    font-weight: 700;
                    margin-bottom: 1.5rem;
                  "
                >حفلة العام المميزة</span
                >
                    </td>
                    <td>
                        <img
                            src="./ticket/images/logo.png"
                            alt="valinteca-logo"
                            style="max-height: 90px; max-width: 80px; object-fit: contain"
                        />
                    </td>
                </tr>

                <tr>
                    <td>
                <span
                    style="
                    display: block;
                    padding: 12px 32px;
                    background-color: #f5f0ea;
                    font-weight: 700;
                    text-align: center;
                    word-spacing: 4px;
                  "
                >14 اكتوبر, 2025</span
                >
                    </td>
                </tr>

                <tr style="height: 25px"></tr>

                <tr>
                    <td>
                        <table>
                            <tr>
                                <td class="info-item">
                                    <span>الوقت:</span>
                                    <small
                                        style="
                          font-weight: 600;
                          font-size: 12px;
                          display: block;
                        "
                                    >4:00 مساءاً</small
                                    >
                                </td>
                                <td class="info-item">
                                    <span>السعر:</span>
                                    <small
                                        style="
                          font-weight: 600;
                          font-size: 12px;
                          display: block;
                        "
                                    >7000 $</small
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td class="info-item" colspan="2">
                                    <span>العنوان:</span>
                                    <small
                                        style="
                          font-weight: 600;
                          font-size: 12px;
                          display: block;
                        "
                                    >ستوديو اّدم,<br/>شارع المدينة , جدة , السعودية</small
                                    >
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <img
                            src="./ticket/images/qr-code.png"
                            alt="qr-code"
                            style="max-height: 90px; max-width: 80px; object-fit: contain"
                        />
                    </td>
                </tr>
            </table>
        </td>

        <td class="part-3">
            <table>
                <colgroup>
                    <col style="width: 60px"/>
                    <col/>
                </colgroup>

                <tr>
                    <td class="serial-code">
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                    </td>
                    <td
                        style="
                  font-weight: 700;
                  font-size: 24px;
                  transform: rotate(90deg);
                  margin-top: 20px;
                "
                    >
                        مميز
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

    <table
    style="width: 600px; margin: 30px 0"
    class="wrapper"
    role="presentation"
>
    <tr>
        <td class="part-2">
            <table cellspacing="0" cellpadding="0" role="presentation">
                <colgroup>
                    <col/>
                    <col style="width: 100px"/>
                </colgroup>

                <tr style="height: 30px;" class="head-row">
                    <td style="padding: 8px;">
                        <span style="color: #fff; margin: 0 5px">رقم التذكرة:</span>
                    </td>
                    <td style="padding: 8px;">
                        <span style="color: #fff; margin: 0 5px">01000000</span>
                    </td>
                </tr>

                <tr style="height: 25px"></tr>

                <tr class="main-row">
                    <td>
                <span
                    style="
                    font-size: 36px;
                    font-weight: 700;
                    margin-bottom: 1.5rem;
                  "
                >حفلة العام المميزة</span
                >
                    </td>
                    <td>
                        <img
                            src="./ticket/images/logo.png"
                            alt="valinteca-logo"
                            style="max-height: 90px; max-width: 80px; object-fit: contain"
                        />
                    </td>
                </tr>

                <tr>
                    <td>
                <span
                    style="
                    display: block;
                    padding: 12px 32px;
                    background-color: #f5f0ea;
                    font-weight: 700;
                    text-align: center;
                    word-spacing: 4px;
                  "
                >14 اكتوبر, 2025</span
                >
                    </td>
                </tr>

                <tr style="height: 25px"></tr>

                <tr>
                    <td>
                        <table>
                            <tr>
                                <td class="info-item">
                                    <span>الوقت:</span>
                                    <small
                                        style="
                          font-weight: 600;
                          font-size: 12px;
                          display: block;
                        "
                                    >4:00 مساءاً</small
                                    >
                                </td>
                                <td class="info-item">
                                    <span>السعر:</span>
                                    <small
                                        style="
                          font-weight: 600;
                          font-size: 12px;
                          display: block;
                        "
                                    >7000 $</small
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td class="info-item" colspan="2">
                                    <span>العنوان:</span>
                                    <small
                                        style="
                          font-weight: 600;
                          font-size: 12px;
                          display: block;
                        "
                                    >ستوديو اّدم,<br/>شارع المدينة , جدة , السعودية</small
                                    >
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <img
                            src="./ticket/images/qr-code.png"
                            alt="qr-code"
                            style="max-height: 90px; max-width: 80px; object-fit: contain"
                        />
                    </td>
                </tr>
            </table>
        </td>

        <td class="part-3">
            <table>
                <colgroup>
                    <col style="width: 60px"/>
                    <col/>
                </colgroup>

                <tr>
                    <td class="serial-code">
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                        <img
                            src="./ticket/images/serial-code.png"
                            alt="serial-code"
                            style="width: 50px; height: 55px; display: block"
                        />
                    </td>
                    <td
                        style="
                  font-weight: 700;
                  font-size: 24px;
                  transform: rotate(90deg);
                  margin-top: 20px;
                "
                    >
                        مميز
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
