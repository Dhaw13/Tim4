function ReviewCard({ name, rating, comment }) {
  return (
    <div className="review-card">
      <h4>{name}</h4>

      <div>
        {"⭐".repeat(rating)}
      </div>

      <p>{comment}</p>
    </div>
  );
}

export default ReviewCard;