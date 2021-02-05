@php
    /** @var \App\Models\BlogCategory $item */
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title"></div>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a href="#maindata" class="nav-link active" data-toggle="tab" role="tab">Main data</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content">
                    <div class="tab-pane active" id="maindata" role="tabpanel">

                        <div class="form-group">
                            <label for="title">Label</label>
                            <input type="text" name="title" id="title" class="form-control" minlength="3" value="{{ $item->title }}" required>
                        </div>

                        <div class="form-group">
                            <label for="slug">Identifier</label>
                            <input type="text" name="slug" id="slug" class="form-control" value="{{ $item->slug }}">
                        </div>

                        <div class="form-group">
                            <label for="parent_id">Parent</label>
                            <select name="parent_id" id="parent_id" class="form-control" placeholder="Choose category" required>
                                @foreach($categoryList as $categoryOption)
                                    <option value="{{ $categoryOption->id }}" @if($categoryOption->id == $item->parent_id) selected @endif> 
                                        {{ $categoryOption->id_title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control">
                                {{ old('description', $item->description) }}
                            </textarea>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>