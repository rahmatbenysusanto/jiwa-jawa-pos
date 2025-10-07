@extends('layout.index')
@section('title', 'Create Menu')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Create Menu</h4>
            </div>
        </div>
        <div class="page-btn">
            <a class="btn btn-primary" onclick="createMenu()"><i class="ti ti-circle-plus me-1"></i>Create Menu</a>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Menu Information</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category</label>
                        <select class="form-control" id="category" name="category">
                            <option value="">-- Choose Category --</option>
                            @foreach($category as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 list position-relative">
                        <label class="form-label">SKU<span class="text-danger ms-1">*</span></label>
                        <input type="text" class="form-control list" id="sku">
                        <button type="submit" class="btn btn-primaryadd">
                            Generate
                        </button>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Menu Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Menu Name ...">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Base Price</label>
                        <input type="number" class="form-control" name="price" id="price" placeholder="Rp ...">
                    </div>
                    <div class="mb-3">
                        <div class="summer-description-box">
                            <label class="form-label">Description</label>
                            <div id="summernote" style="display: none;"></div><div class="note-editor note-frame card"><div class="note-dropzone"><div class="note-dropzone-message"></div></div><div class="note-toolbar card-header" role="toolbar"><div class="note-btn-group btn-group note-style"><div class="note-btn-group btn-group"><button type="button" class="note-btn btn btn-light btn-sm dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-label="Style" data-bs-original-title="Style"><i class="note-icon-magic"></i></button><div class="note-dropdown-menu dropdown-menu dropdown-style" role="list" aria-label="Style"><a class="dropdown-item" href="#" data-value="p" role="listitem" aria-label="p"><p>Normal</p></a><a class="dropdown-item" href="#" data-value="blockquote" role="listitem" aria-label="blockquote"><blockquote class="blockquote">Blockquote</blockquote></a><a class="dropdown-item" href="#" data-value="pre" role="listitem" aria-label="pre"><pre>Code</pre></a><a class="dropdown-item" href="#" data-value="h1" role="listitem" aria-label="h1"><h1>Header 1</h1></a><a class="dropdown-item" href="#" data-value="h2" role="listitem" aria-label="h2"><h2>Header 2</h2></a><a class="dropdown-item" href="#" data-value="h3" role="listitem" aria-label="h3"><h3>Header 3</h3></a><a class="dropdown-item" href="#" data-value="h4" role="listitem" aria-label="h4"><h4>Header 4</h4></a><a class="dropdown-item" href="#" data-value="h5" role="listitem" aria-label="h5"><h5>Header 5</h5></a><a class="dropdown-item" href="#" data-value="h6" role="listitem" aria-label="h6"><h6>Header 6</h6></a></div></div></div><div class="note-btn-group btn-group note-font"><button type="button" class="note-btn btn btn-light btn-sm note-btn-bold" tabindex="-1" aria-label="Bold (⌘+B)" data-bs-original-title="Bold (⌘+B)"><i class="note-icon-bold"></i></button><button type="button" class="note-btn btn btn-light btn-sm note-btn-underline" tabindex="-1" aria-label="Underline (⌘+U)" data-bs-original-title="Underline (⌘+U)"><i class="note-icon-underline"></i></button><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Remove Font Style (⌘+\)" data-bs-original-title="Remove Font Style (⌘+\)"><i class="note-icon-eraser"></i></button></div><div class="note-btn-group btn-group note-fontname"><div class="note-btn-group btn-group"><button type="button" class="note-btn btn btn-light btn-sm dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-label="Font Family" data-bs-original-title="Font Family"><span class="note-current-fontname" style="font-family: Nunito;">Nunito</span></button><div class="note-dropdown-menu dropdown-menu note-check dropdown-fontname" role="list" aria-label="Font Family"><a class="dropdown-item" href="#" data-value="Arial" role="listitem" aria-label="Arial"><i class="note-icon-menu-check"></i> <span style="font-family: 'Arial'">Arial</span></a><a class="dropdown-item" href="#" data-value="Arial Black" role="listitem" aria-label="Arial Black"><i class="note-icon-menu-check"></i> <span style="font-family: 'Arial Black'">Arial Black</span></a><a class="dropdown-item" href="#" data-value="Comic Sans MS" role="listitem" aria-label="Comic Sans MS"><i class="note-icon-menu-check"></i> <span style="font-family: 'Comic Sans MS'">Comic Sans MS</span></a><a class="dropdown-item" href="#" data-value="Courier New" role="listitem" aria-label="Courier New"><i class="note-icon-menu-check"></i> <span style="font-family: 'Courier New'">Courier New</span></a><a class="dropdown-item" href="#" data-value="Helvetica Neue" role="listitem" aria-label="Helvetica Neue"><i class="note-icon-menu-check"></i> <span style="font-family: 'Helvetica Neue'">Helvetica Neue</span></a><a class="dropdown-item" href="#" data-value="Helvetica" role="listitem" aria-label="Helvetica"><i class="note-icon-menu-check"></i> <span style="font-family: 'Helvetica'">Helvetica</span></a><a class="dropdown-item" href="#" data-value="Impact" role="listitem" aria-label="Impact"><i class="note-icon-menu-check"></i> <span style="font-family: 'Impact'">Impact</span></a><a class="dropdown-item" href="#" data-value="Lucida Grande" role="listitem" aria-label="Lucida Grande"><i class="note-icon-menu-check"></i> <span style="font-family: 'Lucida Grande'">Lucida Grande</span></a><a class="dropdown-item" href="#" data-value="Tahoma" role="listitem" aria-label="Tahoma"><i class="note-icon-menu-check"></i> <span style="font-family: 'Tahoma'">Tahoma</span></a><a class="dropdown-item" href="#" data-value="Times New Roman" role="listitem" aria-label="Times New Roman"><i class="note-icon-menu-check"></i> <span style="font-family: 'Times New Roman'">Times New Roman</span></a><a class="dropdown-item" href="#" data-value="Verdana" role="listitem" aria-label="Verdana"><i class="note-icon-menu-check"></i> <span style="font-family: 'Verdana'">Verdana</span></a><a class="dropdown-item checked" href="#" data-value="Nunito" role="listitem" aria-label="Nunito"><i class="note-icon-menu-check"></i> <span style="font-family: 'Nunito'">Nunito</span></a></div></div></div><div class="note-btn-group btn-group note-color"><div class="note-btn-group btn-group note-color note-color-all"><button type="button" class="note-btn btn btn-light btn-sm note-current-color-button" tabindex="-1" aria-label="Recent Color" data-bs-original-title="Recent Color" data-backcolor="#FFFF00" data-forecolor="#000000"><i class="note-icon-font note-recent-color" style="background-color: rgb(255, 255, 0); color: rgb(0, 0, 0);"></i></button><button type="button" class="note-btn btn btn-light btn-sm dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-label="More Color" data-bs-original-title="More Color"></button><div class="note-dropdown-menu dropdown-menu" role="list"><div class="note-palette"><div class="note-palette-title">Background Color</div><div><button type="button" class="note-color-reset btn btn-light btn-default" data-event="backColor" data-value="transparent">Transparent</button></div><div class="note-holder" data-event="backColor"><!-- back colors --><div class="note-color-palette"><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#000000" data-event="backColor" data-value="#000000" aria-label="Black" data-toggle="button" tabindex="-1" data-bs-original-title="Black"></button><button type="button" class="note-color-btn" style="background-color:#424242" data-event="backColor" data-value="#424242" aria-label="Tundora" data-toggle="button" tabindex="-1" data-bs-original-title="Tundora"></button><button type="button" class="note-color-btn" style="background-color:#636363" data-event="backColor" data-value="#636363" aria-label="Dove Gray" data-toggle="button" tabindex="-1" data-bs-original-title="Dove Gray"></button><button type="button" class="note-color-btn" style="background-color:#9C9C94" data-event="backColor" data-value="#9C9C94" aria-label="Star Dust" data-toggle="button" tabindex="-1" data-bs-original-title="Star Dust"></button><button type="button" class="note-color-btn" style="background-color:#CEC6CE" data-event="backColor" data-value="#CEC6CE" aria-label="Pale Slate" data-toggle="button" tabindex="-1" data-bs-original-title="Pale Slate"></button><button type="button" class="note-color-btn" style="background-color:#EFEFEF" data-event="backColor" data-value="#EFEFEF" aria-label="Gallery" data-toggle="button" tabindex="-1" data-bs-original-title="Gallery"></button><button type="button" class="note-color-btn" style="background-color:#F7F7F7" data-event="backColor" data-value="#F7F7F7" aria-label="Alabaster" data-toggle="button" tabindex="-1" data-bs-original-title="Alabaster"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="backColor" data-value="#FFFFFF" aria-label="White" data-toggle="button" tabindex="-1" data-bs-original-title="White"></button></div><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#FF0000" data-event="backColor" data-value="#FF0000" aria-label="Red" data-toggle="button" tabindex="-1" data-bs-original-title="Red"></button><button type="button" class="note-color-btn" style="background-color:#FF9C00" data-event="backColor" data-value="#FF9C00" aria-label="Orange Peel" data-toggle="button" tabindex="-1" data-bs-original-title="Orange Peel"></button><button type="button" class="note-color-btn" style="background-color:#FFFF00" data-event="backColor" data-value="#FFFF00" aria-label="Yellow" data-toggle="button" tabindex="-1" data-bs-original-title="Yellow"></button><button type="button" class="note-color-btn" style="background-color:#00FF00" data-event="backColor" data-value="#00FF00" aria-label="Green" data-toggle="button" tabindex="-1" data-bs-original-title="Green"></button><button type="button" class="note-color-btn" style="background-color:#00FFFF" data-event="backColor" data-value="#00FFFF" aria-label="Cyan" data-toggle="button" tabindex="-1" data-bs-original-title="Cyan"></button><button type="button" class="note-color-btn" style="background-color:#0000FF" data-event="backColor" data-value="#0000FF" aria-label="Blue" data-toggle="button" tabindex="-1" data-bs-original-title="Blue"></button><button type="button" class="note-color-btn" style="background-color:#9C00FF" data-event="backColor" data-value="#9C00FF" aria-label="Electric Violet" data-toggle="button" tabindex="-1" data-bs-original-title="Electric Violet"></button><button type="button" class="note-color-btn" style="background-color:#FF00FF" data-event="backColor" data-value="#FF00FF" aria-label="Magenta" data-toggle="button" tabindex="-1" data-bs-original-title="Magenta"></button></div><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#F7C6CE" data-event="backColor" data-value="#F7C6CE" aria-label="Azalea" data-toggle="button" tabindex="-1" data-bs-original-title="Azalea"></button><button type="button" class="note-color-btn" style="background-color:#FFE7CE" data-event="backColor" data-value="#FFE7CE" aria-label="Karry" data-toggle="button" tabindex="-1" data-bs-original-title="Karry"></button><button type="button" class="note-color-btn" style="background-color:#FFEFC6" data-event="backColor" data-value="#FFEFC6" aria-label="Egg White" data-toggle="button" tabindex="-1" data-bs-original-title="Egg White"></button><button type="button" class="note-color-btn" style="background-color:#D6EFD6" data-event="backColor" data-value="#D6EFD6" aria-label="Zanah" data-toggle="button" tabindex="-1" data-bs-original-title="Zanah"></button><button type="button" class="note-color-btn" style="background-color:#CEDEE7" data-event="backColor" data-value="#CEDEE7" aria-label="Botticelli" data-toggle="button" tabindex="-1" data-bs-original-title="Botticelli"></button><button type="button" class="note-color-btn" style="background-color:#CEE7F7" data-event="backColor" data-value="#CEE7F7" aria-label="Tropical Blue" data-toggle="button" tabindex="-1" data-bs-original-title="Tropical Blue"></button><button type="button" class="note-color-btn" style="background-color:#D6D6E7" data-event="backColor" data-value="#D6D6E7" aria-label="Mischka" data-toggle="button" tabindex="-1" data-bs-original-title="Mischka"></button><button type="button" class="note-color-btn" style="background-color:#E7D6DE" data-event="backColor" data-value="#E7D6DE" aria-label="Twilight" data-toggle="button" tabindex="-1" data-bs-original-title="Twilight"></button></div><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#E79C9C" data-event="backColor" data-value="#E79C9C" aria-label="Tonys Pink" data-toggle="button" tabindex="-1" data-bs-original-title="Tonys Pink"></button><button type="button" class="note-color-btn" style="background-color:#FFC69C" data-event="backColor" data-value="#FFC69C" aria-label="Peach Orange" data-toggle="button" tabindex="-1" data-bs-original-title="Peach Orange"></button><button type="button" class="note-color-btn" style="background-color:#FFE79C" data-event="backColor" data-value="#FFE79C" aria-label="Cream Brulee" data-toggle="button" tabindex="-1" data-bs-original-title="Cream Brulee"></button><button type="button" class="note-color-btn" style="background-color:#B5D6A5" data-event="backColor" data-value="#B5D6A5" aria-label="Sprout" data-toggle="button" tabindex="-1" data-bs-original-title="Sprout"></button><button type="button" class="note-color-btn" style="background-color:#A5C6CE" data-event="backColor" data-value="#A5C6CE" aria-label="Casper" data-toggle="button" tabindex="-1" data-bs-original-title="Casper"></button><button type="button" class="note-color-btn" style="background-color:#9CC6EF" data-event="backColor" data-value="#9CC6EF" aria-label="Perano" data-toggle="button" tabindex="-1" data-bs-original-title="Perano"></button><button type="button" class="note-color-btn" style="background-color:#B5A5D6" data-event="backColor" data-value="#B5A5D6" aria-label="Cold Purple" data-toggle="button" tabindex="-1" data-bs-original-title="Cold Purple"></button><button type="button" class="note-color-btn" style="background-color:#D6A5BD" data-event="backColor" data-value="#D6A5BD" aria-label="Careys Pink" data-toggle="button" tabindex="-1" data-bs-original-title="Careys Pink"></button></div><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#E76363" data-event="backColor" data-value="#E76363" aria-label="Mandy" data-toggle="button" tabindex="-1" data-bs-original-title="Mandy"></button><button type="button" class="note-color-btn" style="background-color:#F7AD6B" data-event="backColor" data-value="#F7AD6B" aria-label="Rajah" data-toggle="button" tabindex="-1" data-bs-original-title="Rajah"></button><button type="button" class="note-color-btn" style="background-color:#FFD663" data-event="backColor" data-value="#FFD663" aria-label="Dandelion" data-toggle="button" tabindex="-1" data-bs-original-title="Dandelion"></button><button type="button" class="note-color-btn" style="background-color:#94BD7B" data-event="backColor" data-value="#94BD7B" aria-label="Olivine" data-toggle="button" tabindex="-1" data-bs-original-title="Olivine"></button><button type="button" class="note-color-btn" style="background-color:#73A5AD" data-event="backColor" data-value="#73A5AD" aria-label="Gulf Stream" data-toggle="button" tabindex="-1" data-bs-original-title="Gulf Stream"></button><button type="button" class="note-color-btn" style="background-color:#6BADDE" data-event="backColor" data-value="#6BADDE" aria-label="Viking" data-toggle="button" tabindex="-1" data-bs-original-title="Viking"></button><button type="button" class="note-color-btn" style="background-color:#8C7BC6" data-event="backColor" data-value="#8C7BC6" aria-label="Blue Marguerite" data-toggle="button" tabindex="-1" data-bs-original-title="Blue Marguerite"></button><button type="button" class="note-color-btn" style="background-color:#C67BA5" data-event="backColor" data-value="#C67BA5" aria-label="Puce" data-toggle="button" tabindex="-1" data-bs-original-title="Puce"></button></div><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#CE0000" data-event="backColor" data-value="#CE0000" aria-label="Guardsman Red" data-toggle="button" tabindex="-1" data-bs-original-title="Guardsman Red"></button><button type="button" class="note-color-btn" style="background-color:#E79439" data-event="backColor" data-value="#E79439" aria-label="Fire Bush" data-toggle="button" tabindex="-1" data-bs-original-title="Fire Bush"></button><button type="button" class="note-color-btn" style="background-color:#EFC631" data-event="backColor" data-value="#EFC631" aria-label="Golden Dream" data-toggle="button" tabindex="-1" data-bs-original-title="Golden Dream"></button><button type="button" class="note-color-btn" style="background-color:#6BA54A" data-event="backColor" data-value="#6BA54A" aria-label="Chelsea Cucumber" data-toggle="button" tabindex="-1" data-bs-original-title="Chelsea Cucumber"></button><button type="button" class="note-color-btn" style="background-color:#4A7B8C" data-event="backColor" data-value="#4A7B8C" aria-label="Smalt Blue" data-toggle="button" tabindex="-1" data-bs-original-title="Smalt Blue"></button><button type="button" class="note-color-btn" style="background-color:#3984C6" data-event="backColor" data-value="#3984C6" aria-label="Boston Blue" data-toggle="button" tabindex="-1" data-bs-original-title="Boston Blue"></button><button type="button" class="note-color-btn" style="background-color:#634AA5" data-event="backColor" data-value="#634AA5" aria-label="Butterfly Bush" data-toggle="button" tabindex="-1" data-bs-original-title="Butterfly Bush"></button><button type="button" class="note-color-btn" style="background-color:#A54A7B" data-event="backColor" data-value="#A54A7B" aria-label="Cadillac" data-toggle="button" tabindex="-1" data-bs-original-title="Cadillac"></button></div><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#9C0000" data-event="backColor" data-value="#9C0000" aria-label="Sangria" data-toggle="button" tabindex="-1" data-bs-original-title="Sangria"></button><button type="button" class="note-color-btn" style="background-color:#B56308" data-event="backColor" data-value="#B56308" aria-label="Mai Tai" data-toggle="button" tabindex="-1" data-bs-original-title="Mai Tai"></button><button type="button" class="note-color-btn" style="background-color:#BD9400" data-event="backColor" data-value="#BD9400" aria-label="Buddha Gold" data-toggle="button" tabindex="-1" data-bs-original-title="Buddha Gold"></button><button type="button" class="note-color-btn" style="background-color:#397B21" data-event="backColor" data-value="#397B21" aria-label="Forest Green" data-toggle="button" tabindex="-1" data-bs-original-title="Forest Green"></button><button type="button" class="note-color-btn" style="background-color:#104A5A" data-event="backColor" data-value="#104A5A" aria-label="Eden" data-toggle="button" tabindex="-1" data-bs-original-title="Eden"></button><button type="button" class="note-color-btn" style="background-color:#085294" data-event="backColor" data-value="#085294" aria-label="Venice Blue" data-toggle="button" tabindex="-1" data-bs-original-title="Venice Blue"></button><button type="button" class="note-color-btn" style="background-color:#311873" data-event="backColor" data-value="#311873" aria-label="Meteorite" data-toggle="button" tabindex="-1" data-bs-original-title="Meteorite"></button><button type="button" class="note-color-btn" style="background-color:#731842" data-event="backColor" data-value="#731842" aria-label="Claret" data-toggle="button" tabindex="-1" data-bs-original-title="Claret"></button></div><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#630000" data-event="backColor" data-value="#630000" aria-label="Rosewood" data-toggle="button" tabindex="-1" data-bs-original-title="Rosewood"></button><button type="button" class="note-color-btn" style="background-color:#7B3900" data-event="backColor" data-value="#7B3900" aria-label="Cinnamon" data-toggle="button" tabindex="-1" data-bs-original-title="Cinnamon"></button><button type="button" class="note-color-btn" style="background-color:#846300" data-event="backColor" data-value="#846300" aria-label="Olive" data-toggle="button" tabindex="-1" data-bs-original-title="Olive"></button><button type="button" class="note-color-btn" style="background-color:#295218" data-event="backColor" data-value="#295218" aria-label="Parsley" data-toggle="button" tabindex="-1" data-bs-original-title="Parsley"></button><button type="button" class="note-color-btn" style="background-color:#083139" data-event="backColor" data-value="#083139" aria-label="Tiber" data-toggle="button" tabindex="-1" data-bs-original-title="Tiber"></button><button type="button" class="note-color-btn" style="background-color:#003163" data-event="backColor" data-value="#003163" aria-label="Midnight Blue" data-toggle="button" tabindex="-1" data-bs-original-title="Midnight Blue"></button><button type="button" class="note-color-btn" style="background-color:#21104A" data-event="backColor" data-value="#21104A" aria-label="Valentino" data-toggle="button" tabindex="-1" data-bs-original-title="Valentino"></button><button type="button" class="note-color-btn" style="background-color:#4A1031" data-event="backColor" data-value="#4A1031" aria-label="Loulou" data-toggle="button" tabindex="-1" data-bs-original-title="Loulou"></button></div></div></div><div><button type="button" class="note-color-select btn btn-light btn-default" data-event="openPalette" data-value="backColorPicker">Select</button><input type="color" id="backColorPicker" class="note-btn note-color-select-btn" value="#FFFF00" data-event="backColorPalette"></div><div class="note-holder-custom" id="backColorPalette" data-event="backColor"><div class="note-color-palette"><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="backColor" data-value="#FFFFFF" aria-label="#FFFFFF" data-toggle="button" tabindex="-1" data-bs-original-title="#FFFFFF"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="backColor" data-value="#FFFFFF" aria-label="#FFFFFF" data-toggle="button" tabindex="-1" data-bs-original-title="#FFFFFF"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="backColor" data-value="#FFFFFF" aria-label="#FFFFFF" data-toggle="button" tabindex="-1" data-bs-original-title="#FFFFFF"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="backColor" data-value="#FFFFFF" aria-label="#FFFFFF" data-toggle="button" tabindex="-1" data-bs-original-title="#FFFFFF"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="backColor" data-value="#FFFFFF" aria-label="#FFFFFF" data-toggle="button" tabindex="-1" data-bs-original-title="#FFFFFF"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="backColor" data-value="#FFFFFF" aria-label="#FFFFFF" data-toggle="button" tabindex="-1" data-bs-original-title="#FFFFFF"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="backColor" data-value="#FFFFFF" aria-label="#FFFFFF" data-toggle="button" tabindex="-1" data-bs-original-title="#FFFFFF"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="backColor" data-value="#FFFFFF" aria-label="#FFFFFF" data-toggle="button" tabindex="-1" data-bs-original-title="#FFFFFF"></button></div></div></div></div><div class="note-palette"><div class="note-palette-title">Text Color</div><div><button type="button" class="note-color-reset btn btn-light btn-default" data-event="removeFormat" data-value="foreColor">Reset to default</button></div><div class="note-holder" data-event="foreColor"><!-- fore colors --><div class="note-color-palette"><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#000000" data-event="foreColor" data-value="#000000" aria-label="Black" data-toggle="button" tabindex="-1" data-bs-original-title="Black"></button><button type="button" class="note-color-btn" style="background-color:#424242" data-event="foreColor" data-value="#424242" aria-label="Tundora" data-toggle="button" tabindex="-1" data-bs-original-title="Tundora"></button><button type="button" class="note-color-btn" style="background-color:#636363" data-event="foreColor" data-value="#636363" aria-label="Dove Gray" data-toggle="button" tabindex="-1" data-bs-original-title="Dove Gray"></button><button type="button" class="note-color-btn" style="background-color:#9C9C94" data-event="foreColor" data-value="#9C9C94" aria-label="Star Dust" data-toggle="button" tabindex="-1" data-bs-original-title="Star Dust"></button><button type="button" class="note-color-btn" style="background-color:#CEC6CE" data-event="foreColor" data-value="#CEC6CE" aria-label="Pale Slate" data-toggle="button" tabindex="-1" data-bs-original-title="Pale Slate"></button><button type="button" class="note-color-btn" style="background-color:#EFEFEF" data-event="foreColor" data-value="#EFEFEF" aria-label="Gallery" data-toggle="button" tabindex="-1" data-bs-original-title="Gallery"></button><button type="button" class="note-color-btn" style="background-color:#F7F7F7" data-event="foreColor" data-value="#F7F7F7" aria-label="Alabaster" data-toggle="button" tabindex="-1" data-bs-original-title="Alabaster"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="foreColor" data-value="#FFFFFF" aria-label="White" data-toggle="button" tabindex="-1" data-bs-original-title="White"></button></div><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#FF0000" data-event="foreColor" data-value="#FF0000" aria-label="Red" data-toggle="button" tabindex="-1" data-bs-original-title="Red"></button><button type="button" class="note-color-btn" style="background-color:#FF9C00" data-event="foreColor" data-value="#FF9C00" aria-label="Orange Peel" data-toggle="button" tabindex="-1" data-bs-original-title="Orange Peel"></button><button type="button" class="note-color-btn" style="background-color:#FFFF00" data-event="foreColor" data-value="#FFFF00" aria-label="Yellow" data-toggle="button" tabindex="-1" data-bs-original-title="Yellow"></button><button type="button" class="note-color-btn" style="background-color:#00FF00" data-event="foreColor" data-value="#00FF00" aria-label="Green" data-toggle="button" tabindex="-1" data-bs-original-title="Green"></button><button type="button" class="note-color-btn" style="background-color:#00FFFF" data-event="foreColor" data-value="#00FFFF" aria-label="Cyan" data-toggle="button" tabindex="-1" data-bs-original-title="Cyan"></button><button type="button" class="note-color-btn" style="background-color:#0000FF" data-event="foreColor" data-value="#0000FF" aria-label="Blue" data-toggle="button" tabindex="-1" data-bs-original-title="Blue"></button><button type="button" class="note-color-btn" style="background-color:#9C00FF" data-event="foreColor" data-value="#9C00FF" aria-label="Electric Violet" data-toggle="button" tabindex="-1" data-bs-original-title="Electric Violet"></button><button type="button" class="note-color-btn" style="background-color:#FF00FF" data-event="foreColor" data-value="#FF00FF" aria-label="Magenta" data-toggle="button" tabindex="-1" data-bs-original-title="Magenta"></button></div><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#F7C6CE" data-event="foreColor" data-value="#F7C6CE" aria-label="Azalea" data-toggle="button" tabindex="-1" data-bs-original-title="Azalea"></button><button type="button" class="note-color-btn" style="background-color:#FFE7CE" data-event="foreColor" data-value="#FFE7CE" aria-label="Karry" data-toggle="button" tabindex="-1" data-bs-original-title="Karry"></button><button type="button" class="note-color-btn" style="background-color:#FFEFC6" data-event="foreColor" data-value="#FFEFC6" aria-label="Egg White" data-toggle="button" tabindex="-1" data-bs-original-title="Egg White"></button><button type="button" class="note-color-btn" style="background-color:#D6EFD6" data-event="foreColor" data-value="#D6EFD6" aria-label="Zanah" data-toggle="button" tabindex="-1" data-bs-original-title="Zanah"></button><button type="button" class="note-color-btn" style="background-color:#CEDEE7" data-event="foreColor" data-value="#CEDEE7" aria-label="Botticelli" data-toggle="button" tabindex="-1" data-bs-original-title="Botticelli"></button><button type="button" class="note-color-btn" style="background-color:#CEE7F7" data-event="foreColor" data-value="#CEE7F7" aria-label="Tropical Blue" data-toggle="button" tabindex="-1" data-bs-original-title="Tropical Blue"></button><button type="button" class="note-color-btn" style="background-color:#D6D6E7" data-event="foreColor" data-value="#D6D6E7" aria-label="Mischka" data-toggle="button" tabindex="-1" data-bs-original-title="Mischka"></button><button type="button" class="note-color-btn" style="background-color:#E7D6DE" data-event="foreColor" data-value="#E7D6DE" aria-label="Twilight" data-toggle="button" tabindex="-1" data-bs-original-title="Twilight"></button></div><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#E79C9C" data-event="foreColor" data-value="#E79C9C" aria-label="Tonys Pink" data-toggle="button" tabindex="-1" data-bs-original-title="Tonys Pink"></button><button type="button" class="note-color-btn" style="background-color:#FFC69C" data-event="foreColor" data-value="#FFC69C" aria-label="Peach Orange" data-toggle="button" tabindex="-1" data-bs-original-title="Peach Orange"></button><button type="button" class="note-color-btn" style="background-color:#FFE79C" data-event="foreColor" data-value="#FFE79C" aria-label="Cream Brulee" data-toggle="button" tabindex="-1" data-bs-original-title="Cream Brulee"></button><button type="button" class="note-color-btn" style="background-color:#B5D6A5" data-event="foreColor" data-value="#B5D6A5" aria-label="Sprout" data-toggle="button" tabindex="-1" data-bs-original-title="Sprout"></button><button type="button" class="note-color-btn" style="background-color:#A5C6CE" data-event="foreColor" data-value="#A5C6CE" aria-label="Casper" data-toggle="button" tabindex="-1" data-bs-original-title="Casper"></button><button type="button" class="note-color-btn" style="background-color:#9CC6EF" data-event="foreColor" data-value="#9CC6EF" aria-label="Perano" data-toggle="button" tabindex="-1" data-bs-original-title="Perano"></button><button type="button" class="note-color-btn" style="background-color:#B5A5D6" data-event="foreColor" data-value="#B5A5D6" aria-label="Cold Purple" data-toggle="button" tabindex="-1" data-bs-original-title="Cold Purple"></button><button type="button" class="note-color-btn" style="background-color:#D6A5BD" data-event="foreColor" data-value="#D6A5BD" aria-label="Careys Pink" data-toggle="button" tabindex="-1" data-bs-original-title="Careys Pink"></button></div><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#E76363" data-event="foreColor" data-value="#E76363" aria-label="Mandy" data-toggle="button" tabindex="-1" data-bs-original-title="Mandy"></button><button type="button" class="note-color-btn" style="background-color:#F7AD6B" data-event="foreColor" data-value="#F7AD6B" aria-label="Rajah" data-toggle="button" tabindex="-1" data-bs-original-title="Rajah"></button><button type="button" class="note-color-btn" style="background-color:#FFD663" data-event="foreColor" data-value="#FFD663" aria-label="Dandelion" data-toggle="button" tabindex="-1" data-bs-original-title="Dandelion"></button><button type="button" class="note-color-btn" style="background-color:#94BD7B" data-event="foreColor" data-value="#94BD7B" aria-label="Olivine" data-toggle="button" tabindex="-1" data-bs-original-title="Olivine"></button><button type="button" class="note-color-btn" style="background-color:#73A5AD" data-event="foreColor" data-value="#73A5AD" aria-label="Gulf Stream" data-toggle="button" tabindex="-1" data-bs-original-title="Gulf Stream"></button><button type="button" class="note-color-btn" style="background-color:#6BADDE" data-event="foreColor" data-value="#6BADDE" aria-label="Viking" data-toggle="button" tabindex="-1" data-bs-original-title="Viking"></button><button type="button" class="note-color-btn" style="background-color:#8C7BC6" data-event="foreColor" data-value="#8C7BC6" aria-label="Blue Marguerite" data-toggle="button" tabindex="-1" data-bs-original-title="Blue Marguerite"></button><button type="button" class="note-color-btn" style="background-color:#C67BA5" data-event="foreColor" data-value="#C67BA5" aria-label="Puce" data-toggle="button" tabindex="-1" data-bs-original-title="Puce"></button></div><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#CE0000" data-event="foreColor" data-value="#CE0000" aria-label="Guardsman Red" data-toggle="button" tabindex="-1" data-bs-original-title="Guardsman Red"></button><button type="button" class="note-color-btn" style="background-color:#E79439" data-event="foreColor" data-value="#E79439" aria-label="Fire Bush" data-toggle="button" tabindex="-1" data-bs-original-title="Fire Bush"></button><button type="button" class="note-color-btn" style="background-color:#EFC631" data-event="foreColor" data-value="#EFC631" aria-label="Golden Dream" data-toggle="button" tabindex="-1" data-bs-original-title="Golden Dream"></button><button type="button" class="note-color-btn" style="background-color:#6BA54A" data-event="foreColor" data-value="#6BA54A" aria-label="Chelsea Cucumber" data-toggle="button" tabindex="-1" data-bs-original-title="Chelsea Cucumber"></button><button type="button" class="note-color-btn" style="background-color:#4A7B8C" data-event="foreColor" data-value="#4A7B8C" aria-label="Smalt Blue" data-toggle="button" tabindex="-1" data-bs-original-title="Smalt Blue"></button><button type="button" class="note-color-btn" style="background-color:#3984C6" data-event="foreColor" data-value="#3984C6" aria-label="Boston Blue" data-toggle="button" tabindex="-1" data-bs-original-title="Boston Blue"></button><button type="button" class="note-color-btn" style="background-color:#634AA5" data-event="foreColor" data-value="#634AA5" aria-label="Butterfly Bush" data-toggle="button" tabindex="-1" data-bs-original-title="Butterfly Bush"></button><button type="button" class="note-color-btn" style="background-color:#A54A7B" data-event="foreColor" data-value="#A54A7B" aria-label="Cadillac" data-toggle="button" tabindex="-1" data-bs-original-title="Cadillac"></button></div><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#9C0000" data-event="foreColor" data-value="#9C0000" aria-label="Sangria" data-toggle="button" tabindex="-1" data-bs-original-title="Sangria"></button><button type="button" class="note-color-btn" style="background-color:#B56308" data-event="foreColor" data-value="#B56308" aria-label="Mai Tai" data-toggle="button" tabindex="-1" data-bs-original-title="Mai Tai"></button><button type="button" class="note-color-btn" style="background-color:#BD9400" data-event="foreColor" data-value="#BD9400" aria-label="Buddha Gold" data-toggle="button" tabindex="-1" data-bs-original-title="Buddha Gold"></button><button type="button" class="note-color-btn" style="background-color:#397B21" data-event="foreColor" data-value="#397B21" aria-label="Forest Green" data-toggle="button" tabindex="-1" data-bs-original-title="Forest Green"></button><button type="button" class="note-color-btn" style="background-color:#104A5A" data-event="foreColor" data-value="#104A5A" aria-label="Eden" data-toggle="button" tabindex="-1" data-bs-original-title="Eden"></button><button type="button" class="note-color-btn" style="background-color:#085294" data-event="foreColor" data-value="#085294" aria-label="Venice Blue" data-toggle="button" tabindex="-1" data-bs-original-title="Venice Blue"></button><button type="button" class="note-color-btn" style="background-color:#311873" data-event="foreColor" data-value="#311873" aria-label="Meteorite" data-toggle="button" tabindex="-1" data-bs-original-title="Meteorite"></button><button type="button" class="note-color-btn" style="background-color:#731842" data-event="foreColor" data-value="#731842" aria-label="Claret" data-toggle="button" tabindex="-1" data-bs-original-title="Claret"></button></div><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#630000" data-event="foreColor" data-value="#630000" aria-label="Rosewood" data-toggle="button" tabindex="-1" data-bs-original-title="Rosewood"></button><button type="button" class="note-color-btn" style="background-color:#7B3900" data-event="foreColor" data-value="#7B3900" aria-label="Cinnamon" data-toggle="button" tabindex="-1" data-bs-original-title="Cinnamon"></button><button type="button" class="note-color-btn" style="background-color:#846300" data-event="foreColor" data-value="#846300" aria-label="Olive" data-toggle="button" tabindex="-1" data-bs-original-title="Olive"></button><button type="button" class="note-color-btn" style="background-color:#295218" data-event="foreColor" data-value="#295218" aria-label="Parsley" data-toggle="button" tabindex="-1" data-bs-original-title="Parsley"></button><button type="button" class="note-color-btn" style="background-color:#083139" data-event="foreColor" data-value="#083139" aria-label="Tiber" data-toggle="button" tabindex="-1" data-bs-original-title="Tiber"></button><button type="button" class="note-color-btn" style="background-color:#003163" data-event="foreColor" data-value="#003163" aria-label="Midnight Blue" data-toggle="button" tabindex="-1" data-bs-original-title="Midnight Blue"></button><button type="button" class="note-color-btn" style="background-color:#21104A" data-event="foreColor" data-value="#21104A" aria-label="Valentino" data-toggle="button" tabindex="-1" data-bs-original-title="Valentino"></button><button type="button" class="note-color-btn" style="background-color:#4A1031" data-event="foreColor" data-value="#4A1031" aria-label="Loulou" data-toggle="button" tabindex="-1" data-bs-original-title="Loulou"></button></div></div></div><div><button type="button" class="note-color-select btn btn-light btn-default" data-event="openPalette" data-value="foreColorPicker">Select</button><input type="color" id="foreColorPicker" class="note-btn note-color-select-btn" value="#000000" data-event="foreColorPalette"></div><div class="note-holder-custom" id="foreColorPalette" data-event="foreColor"><div class="note-color-palette"><div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="foreColor" data-value="#FFFFFF" aria-label="#FFFFFF" data-toggle="button" tabindex="-1" data-bs-original-title="#FFFFFF"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="foreColor" data-value="#FFFFFF" aria-label="#FFFFFF" data-toggle="button" tabindex="-1" data-bs-original-title="#FFFFFF"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="foreColor" data-value="#FFFFFF" aria-label="#FFFFFF" data-toggle="button" tabindex="-1" data-bs-original-title="#FFFFFF"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="foreColor" data-value="#FFFFFF" aria-label="#FFFFFF" data-toggle="button" tabindex="-1" data-bs-original-title="#FFFFFF"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="foreColor" data-value="#FFFFFF" aria-label="#FFFFFF" data-toggle="button" tabindex="-1" data-bs-original-title="#FFFFFF"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="foreColor" data-value="#FFFFFF" aria-label="#FFFFFF" data-toggle="button" tabindex="-1" data-bs-original-title="#FFFFFF"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="foreColor" data-value="#FFFFFF" aria-label="#FFFFFF" data-toggle="button" tabindex="-1" data-bs-original-title="#FFFFFF"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="foreColor" data-value="#FFFFFF" aria-label="#FFFFFF" data-toggle="button" tabindex="-1" data-bs-original-title="#FFFFFF"></button></div></div></div></div></div></div></div><div class="note-btn-group btn-group note-para"><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Unordered list (⌘+⇧+NUM7)" data-bs-original-title="Unordered list (⌘+⇧+NUM7)"><i class="note-icon-unorderedlist"></i></button><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Ordered list (⌘+⇧+NUM8)" data-bs-original-title="Ordered list (⌘+⇧+NUM8)"><i class="note-icon-orderedlist"></i></button><div class="note-btn-group btn-group"><button type="button" class="note-btn btn btn-light btn-sm dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-label="Paragraph" data-bs-original-title="Paragraph"><i class="note-icon-align-left"></i></button><div class="note-dropdown-menu dropdown-menu" role="list"><div class="note-btn-group btn-group note-align"><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Align left (⌘+⇧+L)" data-bs-original-title="Align left (⌘+⇧+L)"><i class="note-icon-align-left"></i></button><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Align center (⌘+⇧+E)" data-bs-original-title="Align center (⌘+⇧+E)"><i class="note-icon-align-center"></i></button><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Align right (⌘+⇧+R)" data-bs-original-title="Align right (⌘+⇧+R)"><i class="note-icon-align-right"></i></button><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Justify full (⌘+⇧+J)" data-bs-original-title="Justify full (⌘+⇧+J)"><i class="note-icon-align-justify"></i></button></div><div class="note-btn-group btn-group note-list"><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Outdent (⌘+[)" data-bs-original-title="Outdent (⌘+[)"><i class="note-icon-align-outdent"></i></button><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Indent (⌘+])" data-bs-original-title="Indent (⌘+])"><i class="note-icon-align-indent"></i></button></div></div></div></div><div class="note-btn-group btn-group note-table"><div class="note-btn-group btn-group"><button type="button" class="note-btn btn btn-light btn-sm dropdown-toggle" tabindex="-1" data-toggle="dropdown" aria-label="Table" data-bs-original-title="Table"><i class="note-icon-table"></i></button><div class="note-dropdown-menu dropdown-menu note-table" role="list" aria-label="Table"><div class="note-dimension-picker"><div class="note-dimension-picker-mousecatcher" data-event="insertTable" data-value="1x1" style="width: 10em; height: 10em;"></div><div class="note-dimension-picker-highlighted"></div><div class="note-dimension-picker-unhighlighted"></div></div><div class="note-dimension-display">1 x 1</div></div></div></div><div class="note-btn-group btn-group note-insert"><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Link (⌘+K)" data-bs-original-title="Link (⌘+K)"><i class="note-icon-link"></i></button><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Picture" data-bs-original-title="Picture"><i class="note-icon-picture"></i></button><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Video" data-bs-original-title="Video"><i class="note-icon-video"></i></button></div><div class="note-btn-group btn-group note-view"><button type="button" class="note-btn btn btn-light btn-sm btn-fullscreen note-codeview-keep" tabindex="-1" aria-label="Full Screen" data-bs-original-title="Full Screen"><i class="note-icon-arrows-alt"></i></button><button type="button" class="note-btn btn btn-light btn-sm btn-codeview note-codeview-keep" tabindex="-1" aria-label="Code View" data-bs-original-title="Code View"><i class="note-icon-code"></i></button><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Help" data-bs-original-title="Help"><i class="note-icon-question"></i></button></div></div><div class="note-editing-area"><div class="note-handle"><div class="note-control-selection" style="display: none;"><div class="note-control-selection-bg"></div><div class="note-control-holder note-control-nw"></div><div class="note-control-holder note-control-ne"></div><div class="note-control-holder note-control-sw"></div><div class="note-control-sizing note-control-se"></div><div class="note-control-selection-info"></div></div></div><textarea class="note-codable" aria-multiline="true"></textarea><div class="note-editable card-block" contenteditable="true" role="textbox" aria-multiline="true" spellcheck="true" autocorrect="true" style="height: 300px;"><p><br></p></div></div><output class="note-status-output" role="status" aria-live="polite"></output><div class="note-statusbar" role="status"><div class="note-resizebar" aria-label="Resize"><div class="note-icon-bar"></div><div class="note-icon-bar"></div><div class="note-icon-bar"></div></div></div><div class="modal note-modal link-dialog" aria-hidden="false" tabindex="-1" role="dialog" aria-label="Insert Link"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">Insert Link</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button></div><div class="modal-body"><div class="form-group note-form-group"><label for="note-dialog-link-txt-17594116354231" class="note-form-label">Text to display</label><input id="note-dialog-link-txt-17594116354231" class="note-link-text form-control note-form-control note-input" type="text"></div><div class="form-group note-form-group"><label for="note-dialog-link-url-17594116354231" class="note-form-label">To what URL should this link go?</label><input id="note-dialog-link-url-17594116354231" class="note-link-url form-control note-form-control note-input" type="text" value="http://"></div><div class="form-check sn-checkbox-open-in-new-window"><label class="form-check-label"><input type="checkbox" class="form-check-input" checked="" aria-label="Open in new window" aria-checked="true"> Open in new window</label></div><div class="form-check sn-checkbox-use-protocol"><label class="form-check-label"><input type="checkbox" class="form-check-input" checked="" aria-label="Use default protocol" aria-checked="true"> Use default protocol</label></div></div><div class="modal-footer"><input type="button" href="#" class="btn btn-primary note-btn note-btn-primary note-link-btn" value="Insert Link" disabled=""></div></div></div></div><div class="note-popover popover in note-link-popover bottom" style="display: none;"><div class="arrow"></div><div class="popover-content note-children-container"><span><a target="_blank"></a>&nbsp;</span><div class="note-btn-group btn-group note-link"><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Edit" data-bs-original-title="Edit"><i class="note-icon-link"></i></button><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Unlink" data-bs-original-title="Unlink"><i class="note-icon-chain-broken"></i></button></div></div></div><div class="modal note-modal" aria-hidden="false" tabindex="-1" role="dialog" aria-label="Insert Image"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">Insert Image</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button></div><div class="modal-body"><div class="form-group note-form-group note-group-select-from-files"><label for="note-dialog-image-file-17594116354231" class="note-form-label">Select from files</label><input id="note-dialog-image-file-17594116354231" class="note-image-input form-control-file note-form-control note-input" type="file" name="files" accept="image/*" multiple="multiple"></div><div class="form-group note-group-image-url"><label for="note-dialog-image-url-17594116354231" class="note-form-label">Image URL</label><input id="note-dialog-image-url-17594116354231" class="note-image-url form-control note-form-control note-input" type="text"></div></div><div class="modal-footer"><input type="button" href="#" class="btn btn-primary note-btn note-btn-primary note-image-btn" value="Insert Image" disabled=""></div></div></div></div><div class="note-popover popover in note-image-popover bottom" style="display: none;"><div class="arrow"></div><div class="popover-content note-children-container"><div class="note-btn-group btn-group note-resize"><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Resize full" data-bs-original-title="Resize full"><span class="note-fontsize-10">100%</span></button><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Resize half" data-bs-original-title="Resize half"><span class="note-fontsize-10">50%</span></button><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Resize quarter" data-bs-original-title="Resize quarter"><span class="note-fontsize-10">25%</span></button><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Original size" data-bs-original-title="Original size"><i class="note-icon-rollback"></i></button></div><div class="note-btn-group btn-group note-float"><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Float Left" data-bs-original-title="Float Left"><i class="note-icon-float-left"></i></button><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Float Right" data-bs-original-title="Float Right"><i class="note-icon-float-right"></i></button><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Remove float" data-bs-original-title="Remove float"><i class="note-icon-rollback"></i></button></div><div class="note-btn-group btn-group note-remove"><button type="button" class="note-btn btn btn-light btn-sm" tabindex="-1" aria-label="Remove Image" data-bs-original-title="Remove Image"><i class="note-icon-trash"></i></button></div></div></div><div class="note-popover popover in note-table-popover bottom" style="display: none;"><div class="arrow"></div><div class="popover-content note-children-container"><div class="note-btn-group btn-group note-add"><button type="button" class="note-btn btn btn-light btn-sm btn-md" tabindex="-1" aria-label="Add row below" data-bs-original-title="Add row below"><i class="note-icon-row-below"></i></button><button type="button" class="note-btn btn btn-light btn-sm btn-md" tabindex="-1" aria-label="Add row above" data-bs-original-title="Add row above"><i class="note-icon-row-above"></i></button><button type="button" class="note-btn btn btn-light btn-sm btn-md" tabindex="-1" aria-label="Add column left" data-bs-original-title="Add column left"><i class="note-icon-col-before"></i></button><button type="button" class="note-btn btn btn-light btn-sm btn-md" tabindex="-1" aria-label="Add column right" data-bs-original-title="Add column right"><i class="note-icon-col-after"></i></button></div><div class="note-btn-group btn-group note-delete"><button type="button" class="note-btn btn btn-light btn-sm btn-md" tabindex="-1" aria-label="Delete row" data-bs-original-title="Delete row"><i class="note-icon-row-remove"></i></button><button type="button" class="note-btn btn btn-light btn-sm btn-md" tabindex="-1" aria-label="Delete column" data-bs-original-title="Delete column"><i class="note-icon-col-remove"></i></button><button type="button" class="note-btn btn btn-light btn-sm btn-md" tabindex="-1" aria-label="Delete table" data-bs-original-title="Delete table"><i class="note-icon-trash"></i></button></div></div></div><div class="modal note-modal" aria-hidden="false" tabindex="-1" role="dialog" aria-label="Insert Video"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">Insert Video</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button></div><div class="modal-body"><div class="form-group note-form-group row-fluid"><label for="note-dialog-video-url-17594116354231" class="note-form-label">Video URL <small class="text-muted">(YouTube, Vimeo, Vine, Instagram, DailyMotion or Youku)</small></label><input id="note-dialog-video-url-17594116354231" class="note-video-url form-control note-form-control note-input" type="text"></div></div><div class="modal-footer"><input type="button" href="#" class="btn btn-primary note-btn note-btn-primary note-video-btn" value="Insert Video" disabled=""></div></div></div></div><div class="modal note-modal" aria-hidden="false" tabindex="-1" role="dialog" aria-label="Help"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">Help</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button></div><div class="modal-body" style="max-height: 300px; overflow: scroll;"><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>ESC</kbd></label><span>Escape</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>ENTER</kbd></label><span>Insert Paragraph</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+Z</kbd></label><span>Undo the last command</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+SHIFT+Z</kbd></label><span>Redo the last command</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>TAB</kbd></label><span>Tab</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>SHIFT+TAB</kbd></label><span>Untab</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+B</kbd></label><span>Set a bold style</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+I</kbd></label><span>Set a italic style</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+U</kbd></label><span>Set a underline style</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+SHIFT+S</kbd></label><span>Set a strikethrough style</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+BACKSLASH</kbd></label><span>Clean a style</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+SHIFT+L</kbd></label><span>Set left align</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+SHIFT+E</kbd></label><span>Set center align</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+SHIFT+R</kbd></label><span>Set right align</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+SHIFT+J</kbd></label><span>Set full align</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+SHIFT+NUM7</kbd></label><span>Toggle unordered list</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+SHIFT+NUM8</kbd></label><span>Toggle ordered list</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+LEFTBRACKET</kbd></label><span>Outdent on current paragraph</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+RIGHTBRACKET</kbd></label><span>Indent on current paragraph</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+NUM0</kbd></label><span>Change current block's format as a paragraph(P tag)</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+NUM1</kbd></label><span>Change current block's format as H1</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+NUM2</kbd></label><span>Change current block's format as H2</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+NUM3</kbd></label><span>Change current block's format as H3</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+NUM4</kbd></label><span>Change current block's format as H4</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+NUM5</kbd></label><span>Change current block's format as H5</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+NUM6</kbd></label><span>Change current block's format as H6</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+ENTER</kbd></label><span>Insert horizontal rule</span><div class="help-list-item"></div><label style="width: 180px; margin-right: 10px;"><kbd>CMD+K</kbd></label><span>Show Link Dialog</span></div><div class="modal-footer"><p class="text-center"><a href="http://summernote.org/" target="_blank">Summernote 0.8.18</a> · <a href="https://github.com/summernote/summernote" target="_blank">Project</a> · <a href="https://github.com/summernote/summernote/issues" target="_blank">Issues</a></p></div></div></div></div></div>
                            <p class="fs-14 mt-1">Maximum 60 Words</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Variant</h4>
                        <a class="btn btn-info btn-sm" onclick="addVariant()">Add Variant</a>
                    </div>
                </div>
            </div>

            <div id="listVariant"></div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        localStorage.clear();

        function addVariant() {
            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];

            variants.push({
                name: '',
                required: true,
                options: [
                    {
                        name: '',
                        price: 0,
                        default: true
                    }
                ]
            });

            localStorage.setItem('variant', JSON.stringify(variants));
            viewVariants();
        }

        function viewVariants() {
            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];

            let html = '';
            variants.forEach((variant, indexVariant) => {
                let htmlOption = '';
                variant.options.forEach((option, indexOption) => {
                    htmlOption += `
                        <div class="row mb-3">
                            <div class="col-4">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" value="${option.name}" placeholder="Large ..." oninput="changeOption(${indexVariant}, ${indexOption}, 'name', this.value)">
                            </div>
                            <div class="col-4">
                                <label class="form-label">Price Delta</label>
                                <input type="number" class="form-control" value="${option.price}" placeholder="Rp ..." oninput="changeOption(${indexVariant}, ${indexOption}, 'price', this.value)">
                            </div>
                            <div class="col-2">
                                <label class="form-label text-white">-</label>
                                <div class="form-check form-check-md form-switch mt-1">
                                    <input class="form-check-input" type="checkbox" role="switch" id="switch-md" ${option.default === true ? 'checked' : ''} onchange="changeOption(${indexVariant}, ${indexOption}, 'default', ${option.default})">
                                    <label class="form-check-label fw-bold" for="switch-md">Default</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label text-white">-</label>
                                <div>
                                    <a class="btn btn-danger" onclick="deleteVariantOption(${indexVariant}, ${indexOption})">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                });

                html += `
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">
                                    <input type="text" class="form-control" value="${variant.name}" placeholder="Variant Name" onchange="changeVariantName(${indexVariant}, this.value)">
                                </div>
                                <div class="col-2 d-flex align-items-center">
                                    <div class="form-check form-check-md form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="switch-md" ${variant.required === true ? 'checked' : ''} onchange="changeVariantRequired(${indexVariant}, ${variant.required})">
                                        <label class="form-check-label fw-bold" for="switch-md">Required</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="d-flex"></div>
                                    <a class="btn btn-danger" onclick="deleteVariant(${indexVariant})">Delete</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Variant Option</h5>
                                <a class="btn btn-secondary btn-sm" onclick="addVariantOption(${indexVariant})">Add Variant Option</a>
                            </div>
                        </div>
                        <div class="card-body">
                            ${htmlOption}
                        </div>
                    </div>
                `;
            });

            document.getElementById('listVariant').innerHTML = html;
        }

        function addVariantOption(indexVariant) {
            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];

            variants[indexVariant].options.push({
                name: '',
                price: 0,
                default: false
            });

            localStorage.setItem('variant', JSON.stringify(variants));
            viewVariants();
        }

        function deleteVariantOption(indexVariant, indexOption) {
            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];
            const options = variants[indexVariant].options;

            options.splice(indexOption, 1);

            localStorage.setItem('variant', JSON.stringify(variants));
            viewVariants();
        }

        function deleteVariant(indexVariant) {
            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];
            variants.splice(indexVariant, 1);
            localStorage.setItem('variant', JSON.stringify(variants));
            viewVariants();
        }

        function changeVariantName(indexVariant, value) {
            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];
            variants[indexVariant].name = value;
            localStorage.setItem('variant', JSON.stringify(variants));
        }

        function changeOption(indexVariant, indexOption, type, value) {
            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];
            const option = variants[indexVariant].options[indexOption];

            if (type === 'name') {
                option.name = value;
            } else if (type === 'price') {
                option.price = value;
            } else {
                if (!value) {
                    option.default = true;

                    variants[indexVariant].options.forEach((opt, i) => {
                        if (i !== indexOption) {
                            opt.default = false;
                        }
                    });
                } else {
                    option.default = false;
                }
            }

            localStorage.setItem('variant', JSON.stringify(variants));

            if (type === 'default') {
                viewVariants();
            }
        }

        function changeVariantRequired(indexVariant, value) {
            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];
            variants[indexVariant].required = !value;
            localStorage.setItem('variant', JSON.stringify(variants));
        }

        function createMenu() {
            // Validation
            const category = document.getElementById('category').value;
            if (category === null || category === '') {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Category not found.',
                    icon: 'warning',
                });
                return true;
            }

            const name = document.getElementById('name').value;
            if (name === null || name === '') {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Name menu not found.',
                    icon: 'warning',
                });
                return true;
            }

            const price = document.getElementById('price').value;
            if (price === null || price === '') {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Base Price not found.',
                    icon: 'warning',
                });
                return true;
            }

            const variants = JSON.parse(localStorage.getItem('variant')) ?? [];
            variants.forEach((variant) => {
                if (variant.name === null || variant.name === '') {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Name Variant not found.',
                        icon: 'warning',
                    });
                    return true;
                }

                variant.options.forEach((opt) => {
                    if (opt.name === null || opt.name === '') {
                        Swal.fire({
                            title: 'Warning!',
                            text: 'Name Variant Option not found.',
                            icon: 'warning',
                        });
                        return true;
                    }

                    if (opt.price === null || opt.price === '') {
                        Swal.fire({
                            title: 'Warning!',
                            text: 'Price Variant Option not found.',
                            icon: 'warning',
                        });
                        return true;
                    }
                });
            });

            Swal.fire({
                title: 'Are you sure?',
                text: "Create New Menu?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes, create it!",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-danger ml-1"
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '{{ route('menu.store') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            category: category,
                            name: name,
                            price: price,
                            variants: variants,
                            sku: document.getElementById('sku').value,
                            desc: document.getElementById('summernote').value
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Menu created successfully.',
                                    icon: 'success',
                                }).then((i) => {
                                    window.location.href = '{{ route('menu.list') }}';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Menu created failed.',
                                    icon: 'error',
                                });
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection

































