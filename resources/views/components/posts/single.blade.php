<div class="blog-post">
                    <div class="blog-thumb">
                      <img src = "{{$post->getThumbnail()}}" alt="{{$post->title}}">
                    </div>
                    <div class="down-content">
                      <span>{{$post->categories[0]->title ?? 'Uncategorized'}}</span>
                      <a href="{{route('view', $post)}}"><h4>{{$post->title}}</h4></a>
                      <ul class="post-info">
                        <li><a href="#">{{$post->user->name}}</a></li>
                        <li><a href="#">{{$post->getFormattedDate()}}</a></li>
                        <li><a href="#">{{$post->human_read_time}}</a></li>
                      </ul>
                      <p>{{$post->shortBody()}}</p>
                      <div class="post-options">
                        <div class="row">
                          <div class="col-6">
                            <ul class="post-tags">
                              <li><i class="fa fa-tags"></i></li>
                              @foreach($post->categories as $category)
                                <a href="#" class="text-blue-700 text-sm font-bold uppercase pb-4">
                                    {{$category->title}}
                                </a>
                            @endforeach
                            </ul>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>



                  