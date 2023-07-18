<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
</script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
    integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

<div class="container">
    <div class="row">
        <div class="col mt-5">
            <h1 class="text-center">Payment Area</h1>
            <form method="POST" action="{{route('pay')}}">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1" class=" m-1">Name</label>
                    <input type="text" class="form-control mb-3"  placeholder="Enter Name">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1" class="m-1">Amount</label>
                    <input type="text" class="form-control mb-3"  placeholder="Enter Amount">
                </div>
                <button type="submit" class="btn btn-primary ">Submit</button>
            </form>
        </div>
    </div>
</div>
