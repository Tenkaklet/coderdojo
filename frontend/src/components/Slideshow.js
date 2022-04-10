import React, { useRef, useState } from "react";
// Import Swiper React components
import { Swiper, SwiperSlide } from "swiper/react";
import kid from '../img/code-kid.jpg'

// Import Swiper styles
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";

// import required modules
import { Autoplay, Pagination, Navigation } from "swiper";

export default function Slideshow() {
  return (
    <div className="h-[500px] relative top-20 bg-[#AE0B05]" >
      <Swiper
        rewind={true}
        spaceBetween={30}
        centeredSlides={true}
        // autoplay={{
        //   delay: 4000,
        //   disableOnInteraction: false,
        // }}
        pagination={{
          clickable: true,
        }}
        navigation={true}
        modules={[Autoplay, Pagination, Navigation]}
        className="h-full flex text-center"
      >
        <SwiperSlide className="flex justify-center items-center"><img className="object-cover w-full h-full" src={kid} alt="coding kid" /></SwiperSlide>
        <SwiperSlide className="flex justify-center items-center"><img className="object-cover w-full h-full" src={kid} alt="coding kid" /></SwiperSlide>
        <SwiperSlide className="flex justify-center items-center"><img className="object-cover w-full h-full" src={kid} alt="coding kid" /></SwiperSlide>
        <SwiperSlide className="flex justify-center items-center"><img className="object-cover w-full h-full" src={kid} alt="coding kid" /></SwiperSlide>
        <SwiperSlide className="flex justify-center items-center"><img className="object-cover w-full h-full" src={kid} alt="coding kid" /></SwiperSlide>
        <SwiperSlide className="flex justify-center items-center"><img className="object-cover w-full h-full" src={kid} alt="coding kid" /></SwiperSlide>
        <SwiperSlide className="flex justify-center items-center"><img className="object-cover w-full h-full" src={kid} alt="coding kid" /></SwiperSlide>
        <SwiperSlide className="flex justify-center items-center"><img className="object-cover w-full h-full" src={kid} alt="coding kid" /></SwiperSlide>
        <SwiperSlide className="flex justify-center items-center"><img className="object-cover w-full h-full" src={kid} alt="coding kid" /></SwiperSlide>
      </Swiper>
      </div>
  );
}