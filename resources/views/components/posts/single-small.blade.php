<div class="col-lg-6">
                  <div class="blog-post">
                    <div class="blog-thumb">
                      <img src="{{ asset($post->image_path) }}" alt="{{ $post->title }}">
                    </div>
                    <div class="down-content">
                      <span>{{ $post->category->name ?? 'Uncategorized' }}</span>
                      <a href="post-details.html"><h4>{{ $post->title }}</h4></a>
                      <ul class="post-info">
                        <li><a href="#">{{ $post->author->name ?? 'Admin' }}</a></li>
                        <li><a href="#">{{ $post->created_at->format('d-m-Y') }}</a></li>
                        <li><a href="#">12 Comments</a></li>
                      </ul>
                      <p>{{ Str::limit($post->body, 50) }}</p>
                      <div class="post-options">
                        <div class="row">
                          <div class="col-lg-12">
                            <ul class="post-tags">
                              <li><i class="fa fa-tags"></i></li>
                              <li><a href="#">Best Templates</a>,</li>
                              <li><a href="#">TemplateMo</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>