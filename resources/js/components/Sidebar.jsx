import React, { useState } from 'react';

const Sidebar = () => {
    const [isYazilarOpen, setIsYazilarOpen] = useState(true);
    const [isSayfalarOpen, setIsSayfalarOpen] = useState(false);

    return (
        <ul className="bg-gradient-to-b from-blue-600 to-blue-800 text-white w-64 h-screen p-0 m-0 list-none">
            <a href="#" className="flex items-center justify-center p-4 text-xl font-bold">
                Blog Sitesi Admin
            </a>
            <hr className="border-gray-300 mx-2" />
            <li className="px-4 py-2 hover:bg-blue-700">
                <a href="#" className="flex items-center text-white">
                    <i className="fas fa-tachometer-alt mr-2"></i>
                    <span>Panel</span>
                </a>
            </li>
            <hr className="border-gray-300 mx-2" />
            <div className="px-4 py-2 text-gray-300 text-sm font-semibold">
                İçerik Yönetimi
            </div>
            <li className="px-4 py-2">
                <a
                    href="#"
                    className="flex items-center text-white hover:bg-blue-700"
                    onClick={() => setIsYazilarOpen(!isYazilarOpen)}
                >
                    <i className="fas fa-edit mr-2"></i>
                    <span>Yazılar</span>
                </a>
                {isYazilarOpen && (
                    <div className="bg-white text-black rounded mt-2">
                        <h6 className="px-4 py-2 text-gray-600 font-semibold">Yazı İşlemleri:</h6>
                        <a href="#" className="block px-4 py-2 hover:bg-gray-200">Tüm Yazılar</a>
                        <a href="#" className="block px-4 py-2 hover:bg-gray-200 text-blue-600 font-semibold">Yazı Oluştur</a>
                    </div>
                )}
            </li>
            <li className="px-4 py-2 hover:bg-blue-700">
                <a href="#" className="flex items-center text-white">
                    <i className="fas fa-list mr-2"></i>
                    <span>Kategoriler</span>
                </a>
            </li>
            <li className="px-4 py-2">
                <a
                    href="#"
                    className="flex items-center text-white hover:bg-blue-700"
                    onClick={() => setIsSayfalarOpen(!isSayfalarOpen)}
                >
                    <i className="fas fa-folder mr-2"></i>
                    <span>Sayfalar</span>
                </a>
                {isSayfalarOpen && (
                    <div className="bg-white text-black rounded mt-2">
                        <h6 className="px-4 py-2 text-gray-600 font-semibold">Sayfa İşlemleri:</h6>
                        <a href="#" className="block px-4 py-2 hover:bg-gray-200">Tüm Sayfalar</a>
                        <a href="#" className="block px-4 py-2 hover:bg-gray-200">Sayfa Oluştur</a>
                    </div>
                )}
            </li>
            <hr className="border-gray-300 mx-2" />
            <div className="text-center hidden md:block">
                <button className="rounded-full border-0 w-8 h-8 bg-gray-300 hover:bg-gray-400">
                    <i className="fas fa-chevron-left"></i>
                </button>
            </div>
        </ul>
    );
};

export default Sidebar;