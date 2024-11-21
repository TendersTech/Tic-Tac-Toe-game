<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment || Tic Tac Toe </title>
    <style>
        body {
            background-color: brown;
            text-align: center;
        }
        #input {
            border: 2px solid black;
            padding: 30px;
            width: 50px;
            height: 15px;
            margin-bottom: 20px;
            margin-top: 20px;
            margin-right: 20px;
            font-size: 30px;
        }
        #goNext {
            width: 100px;
            height: 38px;
            margin-top: 20px;
        }
        .error-message {
            color: yellow;
            font-weight: bold;
            margin-top: 10px;
        }
        .result{
            color: yellow;
        }
    </style>
      <script>
    function validateInput(event) {
                const allowedWords = ['x'];
                const input = event.target.value;
                const errorMessageElement = document.getElementById('error-message');
                const isValid = allowedWords.includes(input.trim().toLowerCase());
                if (input) {
                    if (!isValid) {
                        errorMessageElement.textContent = 'Only X words accepted (Player X)';
                        event.target.value = '';
                    }
                }
    }

    function checkAtLeastOneValue() {
        let inputs = document.querySelectorAll('input[type="text"]');
        let isValid = false;
        const errorMessageElement = document.getElementById('error-message');
        inputs.forEach(input => {
            if (input.value.trim() !== '') {
                isValid = true;
            }
        });        
        if (!isValid) {
            errorMessageElement.textContent = 'enter at least one value to start game!!';
        }      
        return isValid;
    }
    </script>
</head>
<body>
    <div style="margin: 0 auto; width: 75%; text-align: center;">
    <h2 class="result">Let play Tic Tac Toe Game</h2>
    <div id="error-message" class="error-message"></div>
        <form method="post" action="{{ route('game.index') }}">
            @csrf
            @foreach ($box as $i => $value)
                <input type="text" oninput="validateInput(event)" id="input" name="box{{ $i }}" value="{{ $value }}">
                @if ($i == 2 || $i == 5 || $i == 8)
                    <br>
                @endif
            @endforeach

            @if ($outcome === '')
                <input type="submit" name="gobtn" value="Next Move" onclick="return checkAtLeastOneValue()" id="goNext">
            @else
                <input type="button" value="Play Again" id="goNext" onclick="window.location.href='{{ route('game.index') }}'">
            @endif
        </form>

        @if ($outcome)
            <h2 class="result">Game Result: {{ $outcome }}</h2>
        @endif

    </div>
</body>
</html>
