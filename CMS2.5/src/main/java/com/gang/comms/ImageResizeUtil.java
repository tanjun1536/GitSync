package com.gang.comms;

import java.awt.Color;
import java.awt.Image;
import java.awt.image.BufferedImage;
import java.io.IOException;
import java.io.InputStream;

import javax.imageio.ImageIO;

public class ImageResizeUtil {

	
	public static void resize(InputStream stream, int zoomWidth, int zoomHeight, int round) throws IOException{
		Image image = ImageIO.read(stream);
		//画一个固定大小的位图
		BufferedImage tagImage = new BufferedImage(zoomWidth, zoomHeight, BufferedImage.TYPE_INT_RGB);
		//设置背景颜色
		setbackground(tagImage, zoomWidth, zoomHeight, round);
		buildThumbnail(tagImage, image);
	}
	
	
	private static void buildThumbnail(BufferedImage tagImage, Image image){
		//原图矩形
		int x = 0;
		int width = image.getWidth(null);
		int y = 0;
		int height = image.getHeight(null);
		//缩放比例
		float scaled = 0;
		//生成比例
		if(width > height){
			scaled = tagImage.getWidth() / (float)width;
		}
		else{
			scaled = tagImage.getHeight() / (float)height;
		}
		int destWidth,destHeight;
		destWidth = (int)Math.floor(width*scaled);
		destHeight = (int)Math.floor(height*scaled);
		
		//目标图矩形
		int tagX = (tagImage.getWidth() - destWidth)/2;
		int tagWidth = tagImage.getWidth() - tagX;
		int tagY = (tagImage.getHeight() - destHeight)/2;
		int tagHeight = tagImage.getHeight() - tagY;
		tagImage.getGraphics().drawImage(image, tagX, tagY, tagWidth, tagHeight, null);
	}
	
	private static void setbackground(BufferedImage tagImage, int width, int height, int round){
		tagImage.getGraphics().setColor(Color.decode("#6dcff6"));
		tagImage.getGraphics().drawRoundRect(0, 0, width, height, round, round);
	}
}
