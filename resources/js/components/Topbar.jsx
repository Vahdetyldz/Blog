import React, { useState } from 'react';

const Topbar = () => {
    const [isUserDropdownOpen, setIsUserDropdownOpen] = useState(false);
    const [isSearchDropdownOpen, setIsSearchDropdownOpen] = useState(false);

    return (
        <nav className="bg-white shadow p-4 flex justify-between items-center">
            <button className="md:hidden text-gray-600">
                <i className="fas fa-bars"></i>
            </button>
            <ul className="flex items-center space-x-4">
                <li className="sm:hidden relative">
                    <a
                        href="#"
                        className="text-gray-600"
                        onClick={() => setIsSearchDropdownOpen(!isSearchDropdownOpen)}
                    >
                        <i className="fas fa-search"></i>
                    </a>
                    {isSearchDropdownOpen && (
                        <div className="absolute right-0 mt-2 bg-white shadow p-3 rounded">
                            <div className="flex items-center">
                                <input
                                    type="text"
                                    placeholder="Ara..."
                                    className="border rounded p-2 w-full"
                                />
                                <button className="ml-2 bg-blue-600 text-white p-2 rounded">
                                    <i className="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    )}
                </li>
                <div className="hidden sm:block border-l h-6"></div>
                <li className="relative">
                    <a
                        href="#"
                        className="text-gray-600 flex items-center"
                        onClick={() => setIsUserDropdownOpen(!isUserDropdownOpen)}
                    >
                        <span className="hidden lg:inline mr-2">ELİF EKİN BİÇER</span>
                        <i className="fas fa-chevron-down"></i>
                    </a>
                    {isUserDropdownOpen && (
                        <div className="absolute right-0 mt-2 bg-white shadow rounded">
                            <a href="#" className="block px-4 py-2 text-gray-600 hover:bg-gray-200">
                                <i className="fas fa-sign-out-alt mr-2"></i> Çıkış Yap
                            </a>
                        </div>
                    )}
                </li>
            </ul>
        </nav>
    );
};

export default Topbar;