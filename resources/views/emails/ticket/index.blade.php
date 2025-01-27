<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Valinteca - ticket</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@400..700&display=swap"
        rel="stylesheet"
    />
   <style>
       * {
           box-sizing: border-box;
           padding: 0;
           margin: 0;
       }
       body {
           font-family: 'Dastnevis', sans-serif;
           min-height: 100vh;
           display: flex;
           justify-content: center;
           align-items: center;
           background-color: #1e1e1e;
           padding: 0 15px;
       }
       .wrapper {
           width: 860px;
           height: 280px;
           display: flex;
           overflow: hidden;
           position: relative;
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
       .left-ellipses {
           position: absolute;
           height: 90%;
           top: 5%;
           left: -15px;
           display: flex;
           flex-direction: column;
           justify-content: space-between;
       }
       .part-1 .ellipse-lg {
           top: 50%;
           transform: translateY(-50%);
           right: -20px;
           background-color: #1e1e1e;
       }

       .part-1 {
           width: 60px;
           background-color: #222222;
           color: #fff;
           position: relative;
           display: flex;
           align-items: center;
       }
       .part-1 span {
           position: absolute;
           rotate: 90deg;
           white-space: nowrap;
           transform: translateY(-50%);
           height: 20px;
           right: 10px;
       }
       .part-1 span:first-of-type {
           top: 25%;
       }
       .part-1 span:nth-of-type(2) {
           top: 75%;
       }
       .part-2 {
           flex: 1;
           display: flex;
           gap: 1.25rem;
           background-color: #fff;
           color: #000;
           border-left: 2px dashed #000;
           padding: 20px;
       }
       .part-2 .main-content {
           flex: 1;
           display: flex;
           flex-direction: column;
           justify-content: space-between;
           margin: 20px 0;
       }
       .part-2 h1 {
           font-size: 50px;
           line-height: 3.5rem;
           font-weight: 700;
           margin-bottom: 1rem;
       }
       .part-2 .main-content .date {
           padding: 12px 32px;
           background-color: #f5f0ea;
           font-weight: 700;
           text-align: center;
           word-spacing: 4px;
       }
       .info-items-wrapper {
           display: grid;
           grid-template-columns: 1fr 1fr;
           gap: 2.5rem 5rem;
           height: fit-content;
           margin-top: 50px;
       }
       .info-item:nth-child(3) {
           grid-column: span 2;
       }
       .info-item {
           display: flex;
           flex-direction: column;
           gap: 4px;
           color: #323232;
       }
       .info-item span:first-child {
           font-weight: 700;
           color: #000;
       }
       .info-item small {
           font-weight: 600;
           white-space: nowrap;
           font-size: 12px;
           color: #323232;
       }
       .part-2 .actions {
           display: flex;
           flex-direction: column;
           justify-content: space-between;
           flex-shrink: 0;
       }
       .actions img {
           max-height: 90px;
           max-width: 80px;
           object-fit: contain;
       }
       /*  #################################################### */
       .wrapper .part-3 {
           width: 165px;
           background-color: #f5f0ea;
           position: relative;
           display: flex;
           justify-content: center;
           align-items: center;
           gap: 12px;
       }
       .part-3 p {
           font-weight: 700;
           font-size: 24px;
           rotate: 90deg;
           margin-left: 25px;
       }
       .serial-code {
           display: flex;
           flex-direction: column;
           justify-content: center;
           align-items: center;
           gap: 6px;
           margin-right: 35px;
       }
       .serial-code img {
           width: 50px;
           height: 55px;
       }
       .top-ellipse {
           top: -20px;
           right: -20px;
       }
       .bottom-ellipse {
           bottom: -20px;
           right: -20px;
       }

       @media (max-width: 768px) {
           .wrapper {
               width: 95%;
               height: unset;
               flex-direction: column;
               margin: 0 auto;
           }
           .wrapper .ellipse {
               display: none;
           }
           .wrapper .part-1 {
               width: unset;
               flex-direction: row-reverse;
               justify-content: center;
               gap: 1.25rem;
               padding: 12px;
           }
           .part-1 span {
               rotate: unset;
               position: unset;
               transform: unset;
           }
           .part-2 {
               flex-direction: column;
               text-align: center;
               border: unset;
           }
           .part-2 .main-content {
               margin: unset;
           }
           .part-2 .info-items-wrapper {
               margin-top: unset;
           }
           .part-2 .actions {
               flex-direction: row;
           }
           .wrapper .part-3 {
               width: unset;
               flex-direction: column;
               justify-content: center;
               padding: 20px;
           }
           .wrapper .part-3 > div:nth-child(3) {
               display: none;
           }
           .wrapper .part-3 .serial-code {
               flex-direction: row;
               gap: 2px;
               margin: unset;
           }
           .wrapper .part-3 .serial-code img {
               rotate: 90deg;
           }
           .part-3 p {
               rotate: unset;
               margin: unset;
           }
       }

   </style>
</head>
<body>
<div class="wrapper">
    <div class="part-1">
        <div class="ellipse ellipse-lg"></div>
        <span>01000000</span>
        <span>رقم التذكرة:</span>
    </div>

    <div class="part-2">
        <div class="main-content">
            <h1>
                حفلة العام<br />
                المميزة
            </h1>
            <div class="date">14 اكتوبر, 2025</div>
        </div>

        <div class="info-items-wrapper">
            <div class="info-item">
                <span>الوقت:</span>
                <small>4:00 مساءاً</small>
            </div>
            <div class="info-item">
                <span>السعر:</span>
                <small>7000 $</small>
            </div>
            <div class="info-item">
                <span>العنوان:</span>
                <small
                >ستوديو اّدم,<br />
                    شارع المدينة , جدة , السعودية</small
                >
            </div>
        </div>

        <div class="actions">
            <img
                src="./images/logo.png"
                width="100%"
                height="100%"
                alt="valinteca-logo"
            />

            <img
                src="./images/qr-code.png"
                width="100%"
                height="100%"
                alt="qr-code"
            />
        </div>
    </div>

    <div class="part-3">
        <div class="serial-code">
            <img src="./images/serial-code.png" alt="serial-code" />
            <img src="./images/serial-code.png" alt="serial-code" />
            <img src="./images/serial-code.png" alt="serial-code" />
            <img src="./images/serial-code.png" alt="serial-code" />
        </div>
        <p>مميز</p>
        <div>
            <div class="ellipse top-ellipse ellipse-lg"></div>
            <div class="ellipse bottom-ellipse ellipse-lg"></div>
        </div>
    </div>

    <div class="left-ellipses">
        <div class="ellipse ellipse-sm"></div>
        <div class="ellipse ellipse-sm"></div>
        <div class="ellipse ellipse-sm"></div>
        <div class="ellipse ellipse-sm"></div>
        <div class="ellipse ellipse-sm"></div>
    </div>
</div>
</body>
</html>

