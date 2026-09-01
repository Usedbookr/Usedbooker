@if(round($rating) == 5)
<span class="star-rating">
    <i class="bi bi-star-fill"></i>
    <i class="bi bi-star-fill"></i>
    <i class="bi bi-star-fill"></i>
    <i class="bi bi-star-fill"></i>
    <i class="bi bi-star-fill"></i>
</span>
@elseif(round($rating) == 4)
<span class="star-rating">
    <i class="bi bi-star-fill"></i>
    <i class="bi bi-star-fill"></i>
    <i class="bi bi-star-fill"></i>
    <i class="bi bi-star-fill"></i>
    <i class="bi bi-star-fill" style="color: #6b6c6e;"></i>
</span>
@elseif(round($rating) == 3)
<span class="star-rating">
    <i class="bi bi-star-fill"></i>
    <i class="bi bi-star-fill"></i>
    <i class="bi bi-star-fill"></i>
    <i class="bi bi-star-fill" style="color: #6b6c6e;"></i>
    <i class="bi bi-star-fill" style="color: #6b6c6e;"></i>
</span>
@elseif(round($rating) == 2)
<span class="star-rating">
    <i class="bi bi-star-fill"></i>
    <i class="bi bi-star-fill" style="color: #6b6c6e;"></i>
    <i class="bi bi-star-fill" style="color: #6b6c6e;"></i>
    <i class="bi bi-star-fill" style="color: #6b6c6e;"></i>
    <i class="bi bi-star-fill" style="color: #6b6c6e;"></i>
</span>
@elseif(round($rating) == 1)
<span class="star-rating">
    <i class="bi bi-star-fill"></i>
    <i class="bi bi-star-fill" style="color: #6b6c6e;"></i>
    <i class="bi bi-star-fill" style="color: #6b6c6e;"></i>
    <i class="bi bi-star-fill" style="color: #6b6c6e;"></i>
    <i class="bi bi-star-fill" style="color: #6b6c6e;"></i>
</span>
@else
@endif