// components/LoadingOverlay.jsx
import React from 'react';

const LoadingOverlay = ({ message = "Đang thanh toán..." }) => {
  return (
    <div className="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
      <div className="bg-white px-6 py-4 rounded shadow-lg flex items-center gap-3">
        <svg className="animate-spin h-6 w-6 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
          <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
        </svg>
        <span className="text-gray-800 font-medium">{message}</span>
      </div>
    </div>
  );
};

export default LoadingOverlay;
