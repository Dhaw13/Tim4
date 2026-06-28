import { Star } from "lucide-react";

function ReviewSection({ reviews }) {
  return (
    <section
      id="review"
      style={{
        background: "#0d0f14",
        padding: "100px 0",
      }}
    >
      <div className="container">
        <div className="section-header">
          <h2
            style={{
              color: "#fff",
              textAlign: "center",
              marginBottom: "10px",
            }}
          >
            Apa Kata <span style={{ color: "var(--primary)" }}>Mereka?</span>
          </h2>

            <p
            style={{
                textAlign: "center",
                color: "#94a3b8",
                marginBottom: "50px",
            }}
            >
            Review pelanggan yang telah menggunakan produk SIBER.
            </p>

            <div
            style={{
                display: "flex",
                justifyContent: "center",
                gap: "40px",
                marginBottom: "50px",
                color: "#fff",
                flexWrap: "wrap"
            }}
            >
            <div style={{ textAlign: "center" }}>
                <h2 style={{ color: "var(--primary)" }}>4.9</h2>
                <p>Rating</p>
            </div>

            <div style={{ textAlign: "center" }}>
                <h2 style={{ color: "var(--primary)" }}>150+</h2>
                <p>Ulasan</p>
            </div>

            <div style={{ textAlign: "center" }}>
                <h2 style={{ color: "var(--primary)" }}>300+</h2>
                <p>Produk Terjual</p>
            </div>
            </div>
        </div>

        <div
          style={{
            display: "grid",
            gridTemplateColumns: "repeat(auto-fit,minmax(300px,1fr))",
            gap: "24px",
          }}
        >
          {reviews.map((review) => (
            <div
              key={review.id}
              style={{
                background: "#111216",
                border: "1px solid rgba(255,255,255,0.05)",
                borderRadius: "12px",
                padding: "24px",
              }}
            >
              <div
                style={{
                  display: "flex",
                  gap: "3px",
                  marginBottom: "15px",
                }}
              >
                {[...Array(review.rating)].map((_, i) => (
                  <Star
                    key={i}
                    size={16}
                    fill="#f59e0b"
                    color="#f59e0b"
                  />
                ))}
              </div>

              <p
                style={{
                  color: "#cbd5e1",
                  lineHeight: "1.7",
                  marginBottom: "20px",
                }}
              >
                "{review.comment}"
              </p>

              <h4
                style={{
                  color: "#fff",
                  fontWeight: "700",
                }}
              >
                {review.user_name}
              </h4>

              {review.reply && (
                <div
                  style={{
                    marginTop: "16px",
                    padding: "12px",
                    background: "rgba(245,158,11,0.05)",
                    borderLeft: "3px solid var(--primary)",
                    borderRadius: "6px",
                  }}
                >
                  <p
                    style={{
                      fontSize: "12px",
                      color: "var(--primary)",
                      fontWeight: "600",
                      marginBottom: "4px",
                      textTransform: "uppercase",
                      letterSpacing: "0.5px",
                    }}
                  >
                    Balasan Admin
                  </p>
                  <p
                    style={{
                      color: "#e2e8f0",
                      fontSize: "14px",
                      lineHeight: "1.6",
                      margin: 0,
                    }}
                  >
                    "{review.reply}"
                  </p>
                </div>
              )}
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

export default ReviewSection;