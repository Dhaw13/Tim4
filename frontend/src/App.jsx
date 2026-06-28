import { useState, useEffect } from 'react';

// Layouts
import Navbar from './layouts/Navbar';
import Footer from './layouts/Footer';

// Page Sections (Clean, modular names for other programmers)
import HeroSection from './pages/HeroSection';
import AboutSection from './pages/AboutSection';
import ProductSection from './pages/ProductSection';
import ReviewSection from './pages/ReviewSection';

// Components
import ProductDetailModal from './components/ProductDetailModal';

// API
import { api } from './api';

// Product database matching the user's latest updates
const productsData = [
  {
    id: 1,
    name: 'Artikel 1',
    price: 150000,
    category: 'Kaos',
    tag: 'Best Seller',
    description: 'Kaos potongan oversize premium berkelas distro dengan bahan katun tebal lembut khas SIBER. Sangat nyaman digunakan untuk kuliah, santai, maupun nongkrong.',
    rating: 5,
    reviews: 15,
    badgeText: 'HOT ITEM',
    features: ['Bahan 100% Premium Cotton Combed 24s', 'Sablon Plastisol Premium Halus', 'Potongan Oversized Mewah & Unisex']
  },
  {
    id: 2,
    name: 'Artikel 2',
    price: 150000,
    category: 'Kaos',
    tag: 'Best Seller',
    description: 'Kaos potongan oversize premium berkelas distro dengan bahan katun tebal lembut khas SIBER. Sangat nyaman digunakan untuk kuliah, santai, maupun nongkrong.',
    rating: 5,
    reviews: 34,
    badgeText: 'HOT ITEM',
    features: ['Bahan 100% Premium Cotton Combed 24s', 'Sablon Plastisol Premium Halus', 'Potongan Oversized Mewah & Unisex']
  },
  {
    id: 3,
    name: 'Artikel 3',
    price: 150000,
    category: 'Kaos',
    tag: 'Best Seller',
    description: 'Kaos potongan oversize premium berkelas distro dengan bahan katun tebal lembut khas SIBER. Sangat nyaman digunakan untuk kuliah, santai, maupun nongkrong.',
    rating: 5,
    reviews: 4,
    badgeText: 'HOT ITEM',
    features: ['Bahan 100% Premium Cotton Combed 24s', 'Sablon Plastisol Premium Halus', 'Potongan Oversized Mewah & Unisex']
  },
  {
    id: 4,
    name: 'Artikel 4',
    price: 150000,
    category: 'Kaos',
    tag: 'Best Seller',
    description: 'Kaos potongan oversize premium berkelas distro dengan bahan katun tebal lembut khas SIBER. Sangat nyaman digunakan untuk kuliah, santai, maupun nongkrong.',
    rating: 5,
    reviews: 21,
    badgeText: 'HOT ITEM',
    features: ['Bahan 100% Premium Cotton Combed 24s', 'Sablon Plastisol Premium Halus', 'Potongan Oversized Mewah & Unisex']
  }
];

const reviewsData = [];

function App() {
  const [searchQuery, setSearchQuery] = useState('');
  const [activeCategory, setActiveCategory] = useState('Semua');
  const [activeQuickView, setActiveQuickView] = useState(null);
  const [reviews, setReviews] = useState(reviewsData);

  useEffect(() => {
    api.get('/reviews')
      .then((res) => {
        if (res.success) setReviews(res.data);
      })
      .catch(() => {});
  }, []);

  // Smooth scroll helper
  const scrollToId = (id) => {
    const element = document.getElementById(id);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
    }
  };

  return (
    <>
      {/* Top Navbar Layout */}
      <Navbar scrollToId={scrollToId} />

      {/* Main Page Sections */}
      <HeroSection scrollToId={scrollToId} />
      
      <AboutSection />
      
      <ProductSection
        products={productsData}
        searchQuery={searchQuery}
        setSearchQuery={setSearchQuery}
        activeCategory={activeCategory}
        setActiveCategory={setActiveCategory}
        onQuickView={setActiveQuickView}
      />

      <ReviewSection reviews={reviews} />

      <Footer scrollToId={scrollToId} />

      {/* Overlay Product Detail Modal */}
      {activeQuickView && (
        <ProductDetailModal 
          product={activeQuickView}
          onClose={() => setActiveQuickView(null)}
        />
      )}
    </>
  );
}

export default App;
