<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrackDonation</title>
    <!-- Bootstrap CSS の読み込み -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h2>検索してください</h2>
        <form method="POST" action="{{ url('/transaction-detail') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="node">ノード</label>
                <input type="text" class="form-control" id="node" name="node" placeholder="ノードを入力">
            </div>
            <div class="form-group">
                <label for="hash">トランザクションハッシュ</label>
                <input type="text" class="form-control" id="hash" name="hash" placeholder="トランザクションハッシュを入力">
            </div>
            <button type="submit" class="btn btn-primary">送信</button>
        </form>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"
        integrity="sha384-Ltrj3KmKF8lC2WCL3Kb23viTZV2PEH9F0EIIrHClimYI7C2OB4fDHL3c3OykS2ul" crossorigin="anonymous">
    </script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS (Not included) -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha384-ZvpUoO/+PpLXR1lu4jmpXWu80pZlYUAfxl5NsBMWOEPSjUn/6Z/hRTt8+pR6L4N2" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/popper.min.js"
        integrity="sha384-uMNle7Fithnrz4lKn5DgGVVrIxWpT7qzWJdNIu9L0EQBdL+gBkCkUcYdO2Bkdk4r" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8F6FD0OcDQLVFRxej1ZqTfV3lFhFwOYedpY+Win" crossorigin="anonymous">
    </script> -->
</body>

</html>
