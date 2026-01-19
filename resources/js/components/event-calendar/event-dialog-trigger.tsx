import { EventPosition, Events } from '@/types/event';
import { cn } from '@/lib/utils';
import { Button } from '../ui/button';
import { calculateDuration, formatTimeDisplay } from '@/lib/date';
import { getColorClasses, COLOR_CLASSES } from '@/lib/event';
import { AnimatePresence, motion } from 'framer-motion';

type EventDialogTriggerProps = {
  event: Events;
  position: EventPosition;
  leftOffset: number;
  rightOffset: number;
  onClick: (
    event: Events,
    position: EventPosition,
    leftOffset: number,
    rightOffset: number,
  ) => void;
};

export const EventDialogTrigger = ({
  event,
  position,
  leftOffset,
  rightOffset,
  onClick,
}: EventDialogTriggerProps) => {
  const colorClasses = getColorClasses(event.color);
  const isArbitraryColor = !Object.keys(COLOR_CLASSES).includes(event.color);

  const handleClick = (e: React.MouseEvent<HTMLButtonElement>) => {
    e.preventDefault();
    e.stopPropagation();
    onClick(event, position, leftOffset, rightOffset);
  };

  // For arbitrary colors, use inline styles instead of Tailwind classes
  const buttonStyle = isArbitraryColor ? {
    backgroundColor: event.color,
    opacity: 0.8,
  } : {};

  const buttonHoverStyle = isArbitraryColor ? {
    backgroundColor: event.color,
    opacity: 0.9,
  } : {};

  return (
    <AnimatePresence>
      <motion.div
        initial={{ opacity: 0, y: 10, scale: 0.95 }}
        animate={{ opacity: 1, y: 0, scale: 1 }}
        exit={{ opacity: 0, y: -10, scale: 0.95 }}
        transition={{ duration: 0.2 }}
        style={{
          position: 'absolute',
          top: `${position?.top}px`,
          height: `${position?.height}px`,
          left: `calc(${leftOffset}% + 4px)`,
          right: `calc(${rightOffset}% + 4px)`,
          zIndex: 5,
        }}
      >
        <Button
          className={cn(
            'group absolute flex h-full w-full cursor-pointer flex-col items-start justify-start gap-0 overflow-hidden rounded p-2 text-white',
            'border-2 border-white dark:border-white shadow-sm',
            'transition-all duration-200',
            isArbitraryColor ? '' : colorClasses.bg,
          )}
          style={buttonStyle}
          onMouseEnter={(e) => {
            if (isArbitraryColor) {
              Object.assign(e.currentTarget.style, buttonHoverStyle);
            }
          }}
          onMouseLeave={(e) => {
            if (isArbitraryColor) {
              Object.assign(e.currentTarget.style, buttonStyle);
            }
          }}
          onClick={handleClick}
        >
          <div className="text-xs font-medium sm:truncate">{event.title}</div>
          <div className="text-xs sm:truncate">
            {formatTimeDisplay(event.startTime, '12')} -{' '}
            {formatTimeDisplay(event.endTime, '12')}
          </div>
          {position?.height && position.height > 40 && (
            <div className="mt-1 text-xs sm:truncate">
              {calculateDuration?.(event.startTime, event.endTime, 'auto')} Hour
            </div>
          )}
        </Button>
      </motion.div>
    </AnimatePresence>
  );
};
