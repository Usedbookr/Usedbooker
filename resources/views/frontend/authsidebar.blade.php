<?php

    // $author = \App\Models\Books::groupBy('author')->get();
    $author = DB::table('books')
                 ->select('author', DB::raw('count(*) as total'))
                 ->groupBy('author')
                 ->get();
    // dd($author);
    if ($author) {
        $author = $author->toArray();
    }
    // dd($author);
?>


<div class="col-lg-3">
    <div class="categorey-filter-box">
        
        <div class="search-box">
            <h5 class="search-box-title">Search by author name</h5>
            <div class="input-group  ">
                <button class="btn search-btn" type="button" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search..." aria-describedby="button-addon2" value="{{ $id ?? '' }}">
                
                </div>
            </div>

        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Famous Authors
                </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample" style="height: 400px;overflow: auto;">
                <div class="accordion-body">
                    <ul class="author-filter-list">
                        @if($author)
                        @foreach($author as $key => $name)
                        @if($name)
                            <li><a href="{{ route('check.author', $name->author ?? '') }}"> {{ $name->author }} <span>({{ $name->total }})</span></a></li>
                        @else
                            <li><a href=""> {{ $name->author }} <span>({{ $name->total }})</span></a></li>
                        @endif
                        @endforeach
                        @endif
                    </ul>
                </div>
                </div>
            </div>
            
            </div>
    </div>
</div>