<?php $userId = 1002000300 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>modal test</title>
    <style>
        #modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.6);
            z-index: 1000;
        }
        #modal-overlay.show{
            display: block;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <button onclick="openmodal('<?php echo $userId; ?>')">Open Modal</button>

    <div id="modal-overlay">
        <div class="modal-contents">
            <h1>hello this is the modal</h1>
        </div>
    </div>

    <script>
        function openmodal(userId){
            document.getElementById('modal-overlay').classList.add('show');
        }
    </script>
</body>
</html>