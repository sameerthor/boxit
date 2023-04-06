@if(count($products)>0)
          <table class="table table-w-80">
            <thead class="border-n">
              <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                @if(Auth::user()->hasRole('Admin'))
                <th>Action</th>
                @endif
              </tr>
            </thead>
            <tbody class="tr-border td-styles tr-hover">
              @foreach($products as $product)
              <tr>
                <td><b>{{$product->title}}</b></td>
                <td><b>{{$product->description}}</b></td>
                <td><b>{!! !empty($product->image)?"<a class='demo' href='/images/$product->image' data-lightbox='example-$product->id'><img class='example-image' width='200' src='/images/$product->image' ></a>":"" !!}</b></td>
                @if(Auth::user()->hasRole('Admin'))
                <td><img src="img/dots.png" id="dropdownMenuButton" data-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false">
                  <div class="dropdown-menu">
                    <a href="javascript:void(0)" data-id='{{$product->id}}' class="edit dropdown-item">Edit</a>
                    <a href="javascript:void(0)" data-id='{{$product->id}}' class="delete dropdown-item">Delete</a>
                  </div>
                </td>
                @endif
              </tr>
              @endforeach
            </tbody>
          </table>
          @else
          <p>No record found for this department</p>
          @endif