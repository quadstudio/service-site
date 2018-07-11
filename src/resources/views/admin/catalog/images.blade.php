@if(!$catalog->images->isEmpty())
    <div class="d-flex flex-row bd-highlight">
        @foreach($catalog->images as $key => $image)
            <div class="p-2 bd-highlight">
                <img data-id="{{$catalog->id}}" data-number="{{$key + 1}}" style="width: 30px;"
                     alt="{{$image->path}}" class="img-fluid border hover-shadow"
                     src="{{ Storage::disk('equipment')->url($image->path) }}">
            </div>
        @endforeach
    </div>
    <!-- The Modal/Lightbox -->
    <div class="light-box light-box-{{$catalog->id}}">
        <span data-id="{{$catalog->id}}" class="light-box-close cursor">✕</span>
        <div class="light-box-content">
            @foreach($catalog->images as $key => $image)
                <div class="mySlides-{{$catalog->id}}">
                    <div class="numbertext">{{$key + 1}} / {{$catalog->images->count()}}</div>
                    <img src="{{ Storage::disk('equipment')->url($image->path) }}" style="width:100%"/>
                </div>
        @endforeach

        <!-- Next/previous controls -->
            <a class="light-box-prev">&#10094;</a>
            <a class="light-box-next">&#10095;</a>

            <!-- Caption text -->
            <div class="light-box-caption-container">
                <p class="light-box-caption">{{$catalog->name}}</p>
            </div>
            <div class="d-flex flex-row bd-highlight">
                <!-- Thumbnail image controls -->
                @foreach($catalog->images as $key => $image)
                    <div class="">
                        <img data-id="{{$catalog->id}}" data-number="{{$key + 1}}" class="demo" style="width: 50px;"
                             src="{{ Storage::disk('equipment')->url($image->path) }}" alt="">
                    </div>
                @endforeach
            </div>

        </div>
    </div>
    <style>
        /* The Modal (background) */
        .light-box {
            display: none;
            position: fixed;
            z-index: 10000;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: black;
        }

        /* Modal Content */
        .light-box-content {
            position: relative;
            background-color: #fefefe;
            margin: auto;
            padding: 0;
            width: 90%;
            max-width: 500px;
        }

        /* The Close Button */
        .light-box-close {
            color: white;
            position: absolute;
            top: 10px;
            right: 25px;
            font-size: 50px;
            font-weight: bold;
            z-index: 10001;
        }

        .light-box-close:hover,
        .light-box-close:focus {
            color: #999;
            text-decoration: none;
            cursor: pointer;
        }

        /* Hide the slides by default */
        .mySlides {
            display: none;
        }

        /* Next & previous buttons */
        .light-box-prev,
        .light-box-next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -50px;
            color: white !important;
            font-weight: bold;
            font-size: 30px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
            -webkit-user-select: none;
        }

        /* Position the "next button" to the right */
        .light-box-next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .light-box-prev:hover,
        .light-box-next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* Caption text */
        .light-box-caption-container {
            text-align: center;
            background-color: black;
            padding: 2px 16px;
            color: white;
        }

        img.demo {
            opacity: 0.6;
        }

        .active,
        .demo:hover {
            opacity: 1;
        }

        img.hover-shadow {
            transition: 0.3s;
            cursor: pointer;
        }

        .hover-shadow:hover {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
@endif
