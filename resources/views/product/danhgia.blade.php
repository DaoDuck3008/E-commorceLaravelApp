@auth
<div class="review-form mt-4">
    <form method="POST" action="{{ route('product.review', $product->id) }}">
        @csrf
        <h5>Đánh giá sản phẩm</h5>

        <div class="rating">
            @for ($i = 5; $i >= 1; $i--)
                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}">
                <label for="star{{ $i }}">★</label>
            @endfor
        </div>

        <div class="form-group mt-3">
            <textarea name="comment" class="form-control" rows="3"
                      placeholder="Chia sẻ cảm nhận của bạn (tối thiểu 15 ký tự)"></textarea>
        </div>

        <button type="submit" class="btn btn-danger mt-2">GỬI ĐÁNH GIÁ</button>
    </form>
</div>
@else
    <p><a href="{{ route('login') }}">Đăng nhập</a> để đánh giá sản phẩm</p>
@endauth

<style>
.rating {
    direction: rtl;
    unicode-bidi: bidi-override;
    display: inline-flex;
}
.rating input { display: none; }
.rating label {
    font-size: 2rem;
    color: #ccc;
    cursor: pointer;
}
.rating input:checked ~ label,
.rating label:hover,
.rating label:hover ~ label {
    color: gold;
}
</style>
