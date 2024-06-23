<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Valinteca - ticket</title>
  </head>
  <style>
    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'El Messiri', sans-serif;
      background-color: #1e1e1e;
      padding: 0 15px;
      text-align: center;
      min-height: 100vh;
    }
    table {
      border-collapse: collapse;
      margin: auto;
      width: 100%;
    }
    .wrapper {
      width: 100%;
      max-width: 768px;
      overflow: hidden;
      position: relative;
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
    .part-1 {
      background-color: #222222;
      color: #fff;
      position: relative;
      width: 60px;
      text-align: center;
      vertical-align: middle;
    }
    .part-1 .ellipse-lg {
      top: 50%;
      transform: translateY(-50%);
      right: -20px;
      background-color: #1e1e1e;
    }
    .part-1 span {
      display: block;
      margin: 10px 0;
      transform: rotate(90deg);
      white-space: nowrap;
      margin: 100px 0;
    }
    .part-2 {
      background-color: #fff;
      color: #000;
      border-left: 2px dashed #000;
      padding: 20px;
      width: 100%;
    }
    .main-content h1 {
      font-size: 38px;
      line-height: 2.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
    }
    .date {
      padding: 12px 32px;
      background-color: #f5f0ea;
      font-weight: 700;
      text-align: center;
      word-spacing: 4px;
    }
    .info-item {
      margin-bottom: 10px;
    }
    .info-item span {
      font-weight: 700;
      display: block;
    }
    .info-item small {
      font-weight: 600;
      font-size: 12px;
      display: block;
    }
    table.actions td img {
      max-height: 90px;
      max-width: 80px;
      object-fit: contain;
    }
    .actions tr {
      height: 150px; /* Adding space between rows */
    }
    .part-3 {
      background-color: #f5f0ea;
      position: relative;
      width: 165px;
      text-align: center;
      padding-right: 20px;
    }
    table.part-3 tr td span {
        display: block;
      font-weight: 700;
      font-size: 24px;
      transform: rotate(90deg);
      margin-left: 25px;
      margin-top: 20px;
    }
    table.part-3 .serial-code img {
      width: 50px;
      height: 55px;
      display: block;
    }
    table.part-3 .actions tr {
      height: 150px;
    }
    table.part-3  .left-ellipses {
      position: absolute;
      height: 90%;
      top: 5%;
      left: -15px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
  </style>
  <body>
    <table class="wrapper" role="presentation">
      <tr>
        <td class="part-1">
          <span class="ellipse ellipse-lg"></span>
          <span>01000000</span>
          <span>رقم التذكرة:</span>
        </td>
        <td class="part-2">
          <table
            width="100%"
            cellspacing="0"
            cellpadding="0"
            role="presentation"
          >
            <tr>
              <td>
                <span class="main-content">
                  <span style="font-size: 2em; font-weight: bold"
                    >حفلة العام<br />المميزة</span
                  >
                  <span class="date">14 اكتوبر, 2025</span>
                </span>
              </td>
              <td rowspan="2" width="80">
                <table
                  class="actions"
                  width="100%"
                  cellspacing="0"
                  cellpadding="0"
                  role="presentation"
                >
                  <tr>
                    <td>
                      <img src="./ticket/images/logo.png" alt="valinteca-logo" />
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <img src="./ticket/images/qr-code.png" alt="qr-code" />
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table
                  width="100%"
                  cellspacing="0"
                  cellpadding="0"
                  role="presentation"
                >
                  <tr>
                    <td class="info-item">
                      <span>الوقت:</span>
                      <small>4:00 مساءاً</small>
                    </td>
                    <td class="info-item">
                      <span>السعر:</span>
                      <small>7000 $</small>
                    </td>
                  </tr>
                  <tr>
                    <td class="info-item" colspan="2">
                      <span>العنوان:</span>
                      <small
                        >ستوديو اّدم,<br />شارع المدينة , جدة , السعودية</small
                      >
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
        <td class="part-3">
          <table
            width="100%"
            cellspacing="0"
            cellpadding="0"
            role="presentation"
          >
            <tr>
              <td class="serial-code">
                <img src="./ticket/images/serial-code.png" alt="serial-code" />
                <img src="./ticket/images/serial-code.png" alt="serial-code" />
                <img src="./ticket/images/serial-code.png" alt="serial-code" />
                <img src="./ticket/images/serial-code.png" alt="serial-code" />
              </td>
              <td>
                <span>مميز</span>
              </td>
            </tr>
          </table>

          <span class="left-ellipses">
            <span class="ellipse ellipse-sm"></span>
            <span class="ellipse ellipse-sm"></span>
            <span class="ellipse ellipse-sm"></span>
            <span class="ellipse ellipse-sm"></span>
            <span class="ellipse ellipse-sm"></span>
          </span>
        </td>
      </tr>
    </table>
  </body>
</html>
