@extends('layouts.main')

@section('content')
<div class="container-loja">
    <h1>Produtos da Loja</h1>

    @isset($destaque)
        <div class="destaque-box">
            <img src="{{ $destaque->image ? (Str::startsWith($destaque->image, 'http') ? $destaque->image : asset($destaque->image)) : asset('img/sem-foto.jpg') }}"
                 alt="{{ $destaque->name }}"
                 class="destaque-img">
            <div>
                <span class="badge-destaque">Destaque Aleatório</span>
                <h3>{{ $destaque->name }} — {{ number_format($destaque->price, 2, ',', '.') }} €</h3>
                <a href="{{ route('products.show', $destaque->id) }}" class="link-destaque">Ver produto →</a>
            </div>
        </div>
    @endisset

    <form action="{{ route('products.index') }}" method="GET" class="form-pesquisa">
        <input type="text"
               name="pesquisa"
               value="{{ $pesquisa ?? '' }}"
               placeholder="Pesquisar produto por nome ou descrição..."
               class="input-pesquisa">
        <button type="submit" class="button btn-pesquisar">Pesquisar</button>
        @if(!empty($pesquisa))
            <a href="{{ route('products.index') }}" class="button btn-limpar">Limpar</a>
        @endif
    </form>

    <div class="barra-filtros">
        <div class="filtro-categorias">
            <strong>Filtrar por Categoria:</strong>
            <a href="{{ route('products.index') }}" class="button btn-filtro">Todas</a>
            @foreach($categorias as $cat)
                <a href="{{ route('categories.products', $cat->id) }}" class="button btn-filtro">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <div class="filtro-ordenar">
            <strong>Ordenar:</strong>
            <select id="sortSelect" class="select-ordenar">
                <option value="default">Padrão</option>
                <option value="price_asc">Preço ↑ (Menor)</option>
                <option value="price_desc">Preço ↓ (Maior)</option>
                <option value="name_asc">Nome (A–Z)</option>
                <option value="name_desc">Nome (Z–A)</option>
            </select>
        </div>
    </div>

    @if(Auth::check() && Auth::user()->is_admin)
        <a href="{{ route('products.create') }}" class="button btn-criar-produto">Criar Produto</a>
    @endif

    @if(session('success'))
        <div class="alerta-sucesso">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alerta-erro">
            {{ session('error') }}
        </div>
    @endif

    @if($products->isEmpty())
        <p class="sem-resultados">Nenhum produto encontrado para a pesquisa efetuada.</p>
    @else
        <div class="table-responsive">
            <table class="tabela-loja" data-per-page="6">
                <thead>
                    <tr>
                        <th>IMAGEM</th>
                        <th>NOME</th>
                        <th>CATEGORIA</th>
                        <th>PREÇO</th>
                        <th class="col-acoes">AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="productsTbody">
                    @foreach($products as $product)
                    <tr data-product-card data-price="{{ $product->price }}" data-name="{{ $product->name }}">
                        <td>
                            @if($product->image)
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="thumb-produto">
                            @else
                                <img src="{{ asset('img/sem-foto.jpg') }}"
                                     alt="Sem foto"
                                     class="thumb-produto">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="link-produto">
                                {{ $product->name }}
                            </a>
                        </td>
                        <td>
                            @if($product->category)
                                <a href="{{ route('categories.show', $product->category->id) }}">{{ $product->category->name }}</a>
                            @endif
                        </td>
                        <td class="preco-nowrap">{{ number_format($product->price, 2, ',', '.') }} €</td>
                        <td class="col-acoes acoes-links">
                            <a href="{{ route('products.show', $product->id) }}">Detalhes</a>
                            @if(Auth::check() && Auth::user()->is_admin)
                                <a href="{{ route('products.edit', $product->id) }}">Editar</a>
                                <form action="{{ route('products.destroy', $product->id) }}"
                                      method="POST"
                                      class="form-eliminar"
                                      onsubmit="return confirm('Tens a certeza que queres eliminar?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-eliminar">Eliminar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="paginationControls"></div>
    @endif
</div>

<script src="{{ asset('js/catalog-controls.js') }}"></script>
@endsection
