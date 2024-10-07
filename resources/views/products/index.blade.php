<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
            /* Container styling */
    .row {
        display: flex;
        justify-content: center;
        gap: 20px; /* Adds space between the cards */
        margin: 20px 0;
    }
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px;
    }
    
    /* Row styling */
    .row {
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }
    
    /* Card styling */
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: 400px;
        background-color: #fff;
        overflow: hidden;
    }
    
    /* Card hover effect */
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    
    /* Card header styling */
    .card-header {
        background-color: #4CAF50; /* Primary background color */
        color: #fff; /* Text color */
        font-size: 1.5em; /* Font size for heading */
        text-align: center; /* Center-align the text */
        padding: 15px 20px; /* Increased padding for better spacing */
        border-bottom: 2px solid #3E8E41; /* More prominent bottom border */
        font-weight: 700; /* Bolder font for a more professional look */
        letter-spacing: 0.5px; /* Slight letter spacing for readability */
        text-transform: uppercase; /* Uppercase text for a formal, structured look */
        margin-top: 10px; /* Clean margin */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
        border-top-left-radius: 8px; /* Rounded top corners */
        border-top-right-radius: 8px; /* Rounded top corners */
    }
    
    /* Media query for smaller devices */
    @media (max-width: 768px) {
        .card-header {
            font-size: 1.2em; /* Reduce font size on smaller screens */
            padding: 10px; /* Reduce padding for better fit on small devices */
        }
    }
    
    
    /* Card body styling */
    .card-body {
        padding: 20px;
    }
    
    /* Card title styling */
    .card-title {
        font-size: 1.25em;
        font-weight: 600;
        margin-bottom: 15px;
        color: #333;
    }
    
    /* List group styling */
    .list-group {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    /* List group item styling */
    .list-group-item {
        padding: 10px 15px;
        margin-bottom: 8px;
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1em;
        transition: background-color 0.3s ease;
    }
    .price 
    {
        font-size: 50px;
    }
    .currency{
        position: relative;
        font-size: 40px;
    
    }
    
    /* List group item hover effect */
    .list-group-item:hover {
        background-color: #e0e0e0;
        cursor: pointer;
    }

    .image {
    display: flex;
    justify-content: center; /* Centers the image horizontally */
    align-items: center;     /* Centers the image vertically if the div has a height */
    margin: 20px 0;          /* Adds space around the image container */
}

img {
    width: 300px;
    height: 300px;
    object-fit: cover;       /* Ensures the image covers the area without distortion */
    border-radius: 10px;     /* Optional: adds rounded corners to the image */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adds a soft shadow */
}
    
    
    /* Responsive styling */
    @media (max-width: 768px) {
        .card {
            width: 100%;
        }
    }
    </style>
    <title>Pricing</title>
</head>
<body>
    <div class ="container">
        <div class = "row">
             @foreach($products as $productDetails)
            <div class ="card">
            <div class="card-header">
                <h2 class="price">
                    <span class="currency">$</span>
                   {{$productDetails->price}}
                </h2>
            </div>
                <div class="card-body">
                <div class= "image">
                    <img src="{{$productDetails->image }}" alt="W3Schools.com" style="width:300px;height:300px;">
                    </div>
                    <div class="card-title">
                        {{$productDetails->name}}
                    </div>
                    <!-- <ul class="list-group">
                       
                        <li class="list-group-item"></li>
                        
                </ul> -->
                <td>
                        <!-- Link to edit form -->
                        <a href="{{ route('products.edit', $productDetails->id) }}">Edit</a>
                    </td>
                </div>

            </div>
            @endforeach
            <div>
                <form action="{{route('checkout')}}" method="POST">
                    @csrf
            <button type="submit" class="btn btn-primary">Check Out</button>
</form>
            </div>
           
    </div>
    
</body>
</html>
