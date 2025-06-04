<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Alternate Arc Archive</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap');

    body {
      margin: 0;
      padding: 0;
      font-family: 'Inter', sans-serif;
    }

    .banner-wrapper {
      width: 100%;
      max-height: 200px;
      overflow: hidden;
      border-radius: 0.5rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .banner {
      width: 100%;
      height: 210px;
      background-color: #4f7a76;
      color: #f3e9d2;
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      object-fit: cover;
    }

    .shape {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: 0;
    }

    .shape.orange {
      background: #cc5c2f;
      clip-path: ellipse(45% 80% at 100% 0%);
    }

    .shape.yellow {
      background: #f3ca8c;
      clip-path: ellipse(40% 50% at 95% 100%);
    }

    .content {
      position: relative;
      z-index: 1;
      margin-left: 10px;
      margin-right: 10px;
      text-align: center;
    }

    .content h1 {
      font-size: 2.5rem;
      margin: 0;
      font-weight: 700;
    }

    .content p {
      font-size: 1.2rem;
      margin-top: 8px;
    }

    @media (max-width: 768px) {
      .content h1 {
        font-size: 1.8rem;
      }
      .content p {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>

  <div class="banner-wrapper">
    <div class="banner">
      <div class="shape orange"></div>
      <div class="shape yellow"></div>
      <div class="content">
        <h1>Alternate Arc Archive</h1>
        <p>Exploring alternate universe stories</p>
      </div>
    </div>
  </div>

</body>
</html>
