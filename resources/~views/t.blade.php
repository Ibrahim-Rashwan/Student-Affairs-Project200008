<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="/css/dropzone.min.css">
    <script type="text/js" src="/js/dropzone.min.js"></script>
</head>
<body>
    <form action="/tt" method="POST">
        <input type="hidden" name="_token" value={{csrf_token()}}>
        <button type="sumbit">Sumbit</button>
    </form>

    <button onclick="onSumbit()">Non form Sumbit</button>

    <script>
        function onSumbit() {
            console.log('onSumbit')
            // window.location.href = "/tt";

            const xhr = new XMLHttpRequest();
            xhr.open("GET", "/courses", false);

            // Send the proper header information along with the request
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = () => {
                // Call a function when the state changes.
                // console.log('onreadystatechange - xhr.readyState: ' + xhr.readyState + " - xhr.status: " + xhr.status)
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // Request finished. Do processing here.
                    console.log('DONE - response:\n'+xhr.response);
                    // window.location.href = xhr.responseText;
                    // window.location.href = '/courses';
                    window.location.assign(xhr.response)

                }
            };

            xhr.send("_token={{csrf_token()}}");
            // xhr.send(new Int8Array());
            // xhr.send(document);
        }
        // window.onbeforeunload = function() {
        //     return "Dude, are you sure you want to leave? Think of the kittens!";
        // }
    </script>
</body>
</html>
