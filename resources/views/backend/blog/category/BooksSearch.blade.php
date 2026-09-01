
<table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
    <tr>
        <th style="width: 2%;">Sl</th>
        <th style="width: 2%;">Book Id</th>
        <th style="width: 10%;">Name</th> 
        <th style="width: 10%;">Child Category</th> 
        <th style="width: 5%;">Listed By</th> 
        <th style="width: 5%;">Added Date</th> 
        <th style="width: 3%;">Status </th>
        <th style="width: 4%;">Action</th>
    </tr>
    </thead>


    <tbody>
         
        @foreach($books as $key => $item)
        <tr>
            <td> {{ $key + 1 }} </td>
            <td> {{ $item->book_id }} </td>
            <td> {{ $item->name }} </td> 
            <td> {{ $item->category->name ?? '' }} </td>
            <?php
                $list_check = explode(',', $item->section_id);
            ?> 
            <td> 
                {{ $item->listed_by }}
            </td> 
            <td> {{ date('d-m-Y h:i a', strtotime($item->created_at)) }} </td>
            @if($item->status == 1)
            <td> 
            <button class="btn btn-success">Active</button>
            </td>
            @else
            <td> 
            <button class="btn btn-danger">InActive</button>
            </td>
            @endif
            <td>
                <a href="{{ route('books.edit',$item->id) }}" class="btn btn-info sm" title="Edit Data">  <i class="fas fa-edit"></i> </a>

                <a href="{{ route('books.delete',$item->id) }}" data-confirm="Are you delete this book?" class="delete btn btn-danger sm" title="Delete Data" id="delete">  <i class="fas fa-trash-alt"></i> </a>

            </td>
        </tr>
        @endforeach
    
    </tbody>
</table>
<div class="row gy-4 align-items-center" id="seach_hide" style="margin-top: 30px;">
    <div class="col-12">
        {!! $books->withQueryString()->links('pagination::bootstrap-5') !!}
        
    </div>
</div>